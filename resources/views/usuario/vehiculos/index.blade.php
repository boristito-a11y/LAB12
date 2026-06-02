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
            <div class="col-md-4">
                <label class="form-label fw-semibold small text-muted mb-1">BUSCAR</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" id="busquedaLive" class="form-control border-0 bg-light"
                           placeholder="Modelo o marca..." autocomplete="off">
                </div>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold small text-muted mb-1">MARCA</label>
                <select id="filtroMarca" class="form-select border-0 bg-light">
                    <option value="">Todas las marcas</option>
                    @foreach($marcas as $m)
                        <option value="{{ $m->nombre }}">{{ $m->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold small text-muted mb-1">STOCK</label>
                <select id="filtroStock" class="form-select border-0 bg-light">
                    <option value="">Todos</option>
                    <option value="disponible">Disponible</option>
                    <option value="medio">Stock medio</option>
                    <option value="bajo">Pocas unidades</option>
                    <option value="agotado">Agotado</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold small text-muted mb-1">ORDENAR POR</label>
                <select id="filtroOrden" class="form-select border-0 bg-light">
                    <option value="">Sin orden</option>
                    <option value="precio_asc">Precio: menor a mayor</option>
                    <option value="precio_desc">Precio: mayor a menor</option>
                    <option value="anio_desc">Año: más nuevo</option>
                    <option value="anio_asc">Año: más antiguo</option>
                    <option value="km_desc">Kilometraje: mayor</option>
                    <option value="km_asc">Kilometraje: menor</option>
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
         data-stock="{{ $v->estadoStock() }}"
         data-precio="{{ $v->precio }}"
         data-anio="{{ $v->anio }}"
         data-km="{{ $v->kilometraje }}">
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
                @if($v->en_oferta && $v->precio_oferta)
                    <div>
                        <span class="badge rounded-2 mb-1" style="background:#fef2f2;color:#ef4444;font-weight:700">
                            🔥 OFERTA
                        </span><br>
                        <span class="text-muted small" style="text-decoration:line-through">S/. {{ number_format($v->precio, 2) }}</span>
                        <p class="fw-bold fs-5 mb-0" style="color:#ef4444">S/. {{ number_format($v->precio_oferta, 2) }}</p>
                    </div>
                @else
                    <p class="fw-bold fs-5 mb-0" style="color:#059669">S/. {{ number_format($v->precio, 2) }}</p>
                @endif
            </div>

            <div class="card-footer bg-white border-0 px-4 pb-4 pt-2 d-flex gap-2">
                <form action="{{ route('usuario.favoritos.toggle', $v) }}" method="POST">
                    @csrf
                    <button class="btn btn-sm rounded-3 px-2" style="background:#f0f2f5;color:{{ in_array($v->id, $favoritosIds) ? '#ef4444' : '#9ca3af' }}">
                        <i class="bi bi-heart{{ in_array($v->id, $favoritosIds) ? '-fill' : '' }}"></i>
                    </button>
                </form>
                <a href="{{ route('usuario.vehiculos.show', $v) }}"
                   class="btn btn-outline-dark btn-sm rounded-3 flex-fill" style="font-weight:500">
                    <i class="bi bi-eye me-1"></i>Ver detalle
                </a>
                <button class="btn-comparar btn btn-sm rounded-3"
                        style="background:#f0f2f5;color:#374151;font-size:.8rem"
                        data-id="{{ $v->id }}"
                        onclick="toggleComparar('{{ $v->id }}','{{ $v->modelo }}','{{ $v->marca->nombre }}','{{ $v->anio }}','{{ $v->precio }}','{{ $v->kilometraje }}','{{ $v->stock }}')">
                    <i class="bi bi-bar-chart-line me-1"></i>Comparar
                </button>
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

{{-- Barra de comparación --}}
<div id="barraComparar" style="display:none;position:fixed;bottom:0;left:0;right:0;background:#1a1a2e;padding:1rem 2rem;z-index:999;box-shadow:0 -4px 20px rgba(0,0,0,.3)">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-3">
            <span class="text-white fw-semibold">Comparar:</span>
            <span id="nombreV1" class="badge rounded-3 px-3 py-2" style="background:rgba(255,255,255,.1);color:white">—</span>
            <span class="text-white opacity-50">vs</span>
            <span id="nombreV2" class="badge rounded-3 px-3 py-2" style="background:rgba(255,255,255,.1);color:white">—</span>
        </div>
        <div class="d-flex gap-2">
            <button onclick="limpiarComparacion()" class="btn btn-sm btn-outline-light rounded-3">Limpiar</button>
            <button onclick="verComparacion()" id="btnComparar" class="btn btn-sm rounded-3 fw-semibold" style="background:#f59e0b;color:#1a1a2e" disabled>
                <i class="bi bi-bar-chart-line me-1"></i>Comparar
            </button>
        </div>
    </div>
</div>

{{-- Modal comparación --}}
<div id="modalComparar" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.7);z-index:9999;align-items:center;justify-content:center;padding:1rem">
    <div class="bg-white rounded-4 shadow-lg p-4" style="max-width:700px;width:100%;max-height:90vh;overflow-y:auto">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold mb-0" style="color:#1a1a2e"><i class="bi bi-bar-chart-line me-2"></i>Comparación de Vehículos</h5>
            <button onclick="cerrarModal()" class="btn btn-light btn-sm rounded-3"><i class="bi bi-x-lg"></i></button>
        </div>
        <div id="tablaComparacion"></div>
    </div>
</div>

<script>
const busqueda     = document.getElementById('busquedaLive');
const filtroM      = document.getElementById('filtroMarca');
const filtroS      = document.getElementById('filtroStock');
const filtroO      = document.getElementById('filtroOrden');
const sinRes       = document.getElementById('sinResultados');
const ordenOriginal = Array.from(document.querySelectorAll('#catalogoGrid .tarjeta-vehiculo'));

function filtrar() {
    const texto = busqueda.value.toLowerCase().trim();
    const marca = filtroM.value.toLowerCase();
    const stock = filtroS.value;
    const orden = filtroO.value;
    const grid  = document.getElementById('catalogoGrid');

    // 1. Mostrar/ocultar
    let visibles = 0;
    document.querySelectorAll('.tarjeta-vehiculo').forEach(t => {
        const ok = (!texto || t.dataset.modelo.includes(texto) || t.dataset.marca.includes(texto))
                && (!marca || t.dataset.marca === marca)
                && (!stock || t.dataset.stock === stock);
        t.style.display = ok ? '' : 'none';
        if (ok) visibles++;
    });
    sinRes.classList.toggle('d-none', visibles > 0);

    // 2. Ordenar
    if (!orden) {
        ordenOriginal.forEach(t => grid.appendChild(t));
    } else {
        const cols = Array.from(grid.querySelectorAll('.tarjeta-vehiculo'))
            .filter(c => c.style.display !== 'none');

        cols.sort((a, b) => {
            const pa = parseFloat(a.dataset.precio), pb = parseFloat(b.dataset.precio);
            const aa = parseInt(a.dataset.anio),     ab = parseInt(b.dataset.anio);
            const ka = parseInt(a.dataset.km),       kb = parseInt(b.dataset.km);
            if (orden === 'precio_asc')  return pa - pb;
            if (orden === 'precio_desc') return pb - pa;
            if (orden === 'anio_desc')   return ab - aa;
            if (orden === 'anio_asc')    return aa - ab;
            if (orden === 'km_asc')      return ka - kb;
            if (orden === 'km_desc')     return kb - ka;
            return 0;
        });

        cols.forEach(c => grid.appendChild(c));
    }
}

function limpiarFiltros() {
    busqueda.value = ''; filtroM.value = ''; filtroS.value = ''; filtroO.value = ''; filtrar();
}
busqueda.addEventListener('input', filtrar);
filtroM.addEventListener('change', filtrar);
filtroS.addEventListener('change', filtrar);
filtroO.addEventListener('change', filtrar);

// ── Comparación ──
let seleccionados = {};

function toggleComparar(id, modelo, marca, anio, precio, km, stock) {
    if (seleccionados[id]) {
        delete seleccionados[id];
    } else {
        if (Object.keys(seleccionados).length >= 2) {
            alert('Solo puedes comparar 2 vehículos a la vez.');
            return;
        }
        seleccionados[id] = { id, modelo, marca, anio, precio, km, stock };
    }
    actualizarBarra();
}

function actualizarBarra() {
    const keys = Object.keys(seleccionados);
    const barra = document.getElementById('barraComparar');
    const btn   = document.getElementById('btnComparar');

    document.querySelectorAll('.btn-comparar').forEach(b => {
        const id = b.dataset.id;
        if (seleccionados[id]) {
            b.style.background = '#f59e0b';
            b.style.color = '#1a1a2e';
            b.innerHTML = '<i class="bi bi-check-lg me-1"></i>Seleccionado';
        } else {
            b.style.background = '#f0f2f5';
            b.style.color = '#374151';
            b.innerHTML = '<i class="bi bi-bar-chart-line me-1"></i>Comparar';
        }
    });

    if (keys.length > 0) {
        barra.style.display = 'block';
        document.getElementById('nombreV1').textContent = seleccionados[keys[0]] ? seleccionados[keys[0]].modelo + ' ' + seleccionados[keys[0]].marca : '—';
        document.getElementById('nombreV2').textContent = seleccionados[keys[1]] ? seleccionados[keys[1]].modelo + ' ' + seleccionados[keys[1]].marca : '—';
        btn.disabled = keys.length < 2;
    } else {
        barra.style.display = 'none';
    }
}

function verComparacion() {
    const keys = Object.keys(seleccionados);
    const v1   = seleccionados[keys[0]];
    const v2   = seleccionados[keys[1]];

    const mejor = (val1, val2, menorEsMejor = false) => {
        if (val1 === val2) return ['', ''];
        const gana = menorEsMejor ? (val1 < val2) : (val1 > val2);
        return gana ? ['style="color:#059669;font-weight:700"', 'style="color:#9ca3af"']
                    : ['style="color:#9ca3af"', 'style="color:#059669;font-weight:700"'];
    };

    const [s1p, s2p] = mejor(v1.precio, v2.precio, true);
    const [s1k, s2k] = mejor(v1.km, v2.km, true);
    const [s1a, s2a] = mejor(v1.anio, v2.anio);

    document.getElementById('tablaComparacion').innerHTML = `
        <table class="table text-center align-middle">
            <thead>
                <tr>
                    <th class="text-start" style="color:#9ca3af;font-size:.8rem">CARACTERÍSTICA</th>
                    <th style="color:#1a1a2e">${v1.modelo}<br><small class="text-muted fw-normal">${v1.marca}</small></th>
                    <th style="color:#1a1a2e">${v2.modelo}<br><small class="text-muted fw-normal">${v2.marca}</small></th>
                </tr>
            </thead>
            <tbody>
                <tr style="background:#f8fafc">
                    <td class="text-start text-muted small fw-semibold">AÑO</td>
                    <td ${s1a}>${v1.anio}</td>
                    <td ${s2a}>${v2.anio}</td>
                </tr>
                <tr>
                    <td class="text-start text-muted small fw-semibold">PRECIO</td>
                    <td ${s1p}>S/. ${parseFloat(v1.precio).toLocaleString('es-PE', {minimumFractionDigits:2})}</td>
                    <td ${s2p}>S/. ${parseFloat(v2.precio).toLocaleString('es-PE', {minimumFractionDigits:2})}</td>
                </tr>
                <tr style="background:#f8fafc">
                    <td class="text-start text-muted small fw-semibold">KILOMETRAJE</td>
                    <td ${s1k}>${parseInt(v1.km).toLocaleString()} km</td>
                    <td ${s2k}>${parseInt(v2.km).toLocaleString()} km</td>
                </tr>
                <tr>
                    <td class="text-start text-muted small fw-semibold">STOCK</td>
                    <td>${v1.stock} unidades</td>
                    <td>${v2.stock} unidades</td>
                </tr>
            </tbody>
        </table>
        <p class="text-muted small text-center mt-2"><i class="bi bi-info-circle me-1"></i>Los valores en <span style="color:#059669;font-weight:700">verde</span> indican la mejor opción.</p>
    `;
    document.getElementById('modalComparar').style.display = 'flex';
}

function limpiarComparacion() {
    seleccionados = {};
    actualizarBarra();
}

function cerrarModal() {
    document.getElementById('modalComparar').style.display = 'none';
}
</script>
@endsection