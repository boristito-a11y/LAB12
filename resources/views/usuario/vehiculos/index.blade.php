@extends('layouts.app')
@section('content')

@if(session('compra_exitosa'))
<div class="modal fade show d-block" tabindex="-1" style="background:rgba(0,0,0,.6)">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 text-center p-5">
            <div style="font-size:4rem">✅</div>
            <h3 class="fw-bold mt-2">¡Pago Exitoso!</h3>
            <p class="text-muted">Tu compra fue procesada correctamente. ¡Gracias por tu preferencia!</p>
            <button class="btn btn-dark rounded-3 mt-2 px-4" onclick="this.closest('.modal').remove()">Cerrar</button>
        </div>
    </div>
</div>
@endif

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-0" style="color:#1a1a2e">Catálogo de Vehículos</h2>
        <p class="text-muted mb-0 small">Encontrá tu próximo auto</p>
    </div>
</div>

{{-- Filtros --}}
<div class="card border-0 rounded-4 shadow-sm mb-4" style="background:white">
    <div class="card-body p-3">
        <div class="row g-2 align-items-end">
            <div class="col-md-5">
                <label class="form-label fw-semibold small text-muted mb-1">BUSCAR</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" id="busquedaLive" class="form-control border-0 bg-light"
                           placeholder="Modelo o marca..." autocomplete="off">
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold small text-muted mb-1">MARCA</label>
                <select id="filtroMarca" class="form-select border-0 bg-light">
                    <option value="">Todas las marcas</option>
                    @foreach($marcas as $m)
                        <option value="{{ $m->nombre }}">{{ $m->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold small text-muted mb-1">STOCK</label>
                <select id="filtroStock" class="form-select border-0 bg-light">
                    <option value="">Todos</option>
                    <option value="disponible">Disponible</option>
                    <option value="medio">Stock medio</option>
                    <option value="bajo">Pocas unidades</option>
                    <option value="agotado">Agotado</option>
                </select>
            </div>
            <div class="col-md-1">
                <button class="btn btn-light w-100 border-0 bg-light" onclick="limpiarFiltros()" title="Limpiar">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<div id="sinResultados" class="alert alert-warning rounded-3 d-none">
    <i class="bi bi-search me-2"></i>No se encontraron vehículos con ese criterio.
</div>

<div class="row row-cols-1 row-cols-md-3 g-4" id="catalogoGrid">
    @foreach($vehiculos as $v)
    <div class="col tarjeta-vehiculo"
         data-modelo="{{ strtolower($v->modelo) }}"
         data-marca="{{ strtolower($v->marca->nombre) }}"
         data-stock="{{ $v->estadoStock() }}">
        <div class="card h-100 border-0 rounded-4 shadow-sm overflow-hidden" style="transition: transform .2s, box-shadow .2s"
             onmouseenter="this.style.transform='translateY(-4px)';this.style.boxShadow='0 12px 32px rgba(0,0,0,.15)'"
             onmouseleave="this.style.transform='';this.style.boxShadow=''">

            <div style="position:relative;height:210px;overflow:hidden;background:#e8eaf0">
                @if($v->foto)
                    <img src="{{ asset('storage/' . $v->foto) }}"
                         style="width:100%;height:100%;object-fit:cover;object-position:center"
                         onerror="this.style.display='none';this.nextElementSibling.style.display='flex'"
                         alt="{{ $v->modelo }}">
                    <div style="display:none;width:100%;height:100%;align-items:center;justify-content:center;font-size:3.5rem;color:#9ca3af">
                        <i class="bi bi-car-front"></i>
                    </div>
                @else
                    <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:3.5rem;color:#9ca3af">
                        <i class="bi bi-car-front"></i>
                    </div>
                @endif
                <div style="position:absolute;top:.75rem;right:.75rem">{!! $v->badgeStock() !!}</div>
            </div>

            <div class="card-body px-4 pt-3 pb-2">
                <p class="text-muted small mb-1 fw-semibold" style="letter-spacing:.5px">{{ strtoupper($v->marca->nombre) }} · {{ $v->anio }}</p>
                <h5 class="fw-bold mb-1" style="color:#1a1a2e">{{ $v->modelo }}</h5>
                <p class="text-muted small mb-2"><i class="bi bi-speedometer2 me-1"></i>{{ number_format($v->kilometraje) }} km</p>
                <p class="fw-bold fs-5 mb-0" style="color:#059669">S/. {{ number_format($v->precio, 2) }}</p>
            </div>

            <div class="card-footer bg-white border-0 px-4 pb-4 pt-2 d-flex gap-2">
                <a href="{{ route('usuario.vehiculos.show', $v) }}"
                   class="btn btn-outline-dark btn-sm rounded-3 flex-fill" style="font-weight:500">
                    <i class="bi bi-eye me-1"></i>Ver detalle
                </a>
                @if($v->stock > 0)
                    <form action="{{ route('usuario.carrito.agregar', $v) }}" method="POST" class="flex-fill">
                        @csrf
                        <button class="btn btn-dark btn-sm rounded-3 w-100" style="font-weight:500">
                            <i class="bi bi-cart-plus me-1"></i>Agregar
                        </button>
                    </form>
                @else
                    <button class="btn btn-secondary btn-sm rounded-3 flex-fill" disabled>Sin stock</button>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>

<script>
const busqueda = document.getElementById('busquedaLive');
const filtroM  = document.getElementById('filtroMarca');
const filtroS  = document.getElementById('filtroStock');
const tarjetas = document.querySelectorAll('.tarjeta-vehiculo');
const sinRes   = document.getElementById('sinResultados');

function filtrar() {
    const texto = busqueda.value.toLowerCase().trim();
    const marca = filtroM.value.toLowerCase();
    const stock = filtroS.value;
    let visibles = 0;
    tarjetas.forEach(t => {
        const ok = (!texto || t.dataset.modelo.includes(texto) || t.dataset.marca.includes(texto))
                && (!marca || t.dataset.marca === marca)
                && (!stock || t.dataset.stock === stock);
        t.style.display = ok ? '' : 'none';
        if (ok) visibles++;
    });
    sinRes.classList.toggle('d-none', visibles > 0);
}
function limpiarFiltros() {
    busqueda.value = ''; filtroM.value = ''; filtroS.value = ''; filtrar();
}
busqueda.addEventListener('input', filtrar);
filtroM.addEventListener('change', filtrar);
filtroS.addEventListener('change', filtrar);
</script>
@endsection