@extends('layouts.app')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-0" style="color:#1a1a2e">❤️ Mis Favoritos</h2>
        <p class="text-muted small mb-0">{{ $favoritos->count() }} vehículos guardados</p>
    </div>
</div>

@if($favoritos->isEmpty())
    <div class="card border-0 rounded-4 shadow-sm text-center p-5">
        <div style="font-size:4rem;color:#d1d5db">❤️</div>
        <h4 class="mt-3 fw-bold" style="color:#1a1a2e">No tienes favoritos aún</h4>
        <p class="text-muted">Guardá los vehículos que más te gusten.</p>
        <a href="{{ route('usuario.vehiculos.index') }}" class="btn btn-dark rounded-3 px-4 mt-2">Ver catálogo</a>
    </div>
@else
<div class="row row-cols-1 row-cols-md-3 g-4">
    @foreach($favoritos as $fav)
    @php $v = $fav->vehiculo; @endphp
    <div class="col">
        <div class="card h-100 border-0 rounded-4 shadow-sm overflow-hidden">
            <div style="height:200px;overflow:hidden;background:#e8eaf0;position:relative">
                @if($v->foto)
                    <img src="{{ asset('storage/' . $v->foto) }}" style="width:100%;height:100%;object-fit:cover">
                @else
                    <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:3rem;color:#9ca3af">
                        <i class="bi bi-car-front"></i>
                    </div>
                @endif
                <form action="{{ route('usuario.favoritos.toggle', $v) }}" method="POST" style="position:absolute;top:.75rem;right:.75rem">
                    @csrf
                    <button class="btn btn-sm rounded-circle" style="background:white;width:36px;height:36px;padding:0;color:#ef4444;box-shadow:0 2px 8px rgba(0,0,0,.15)">
                        <i class="bi bi-heart-fill"></i>
                    </button>
                </form>
            </div>
            <div class="card-body px-4 pt-3 pb-2">
                <p class="text-muted small mb-1 fw-semibold">{{ strtoupper($v->marca->nombre) }} · {{ $v->anio }}</p>
                <h5 class="fw-bold mb-1" style="color:#1a1a2e">{{ $v->modelo }}</h5>
                @if($v->en_oferta && $v->precio_oferta)
                    <span class="badge rounded-2 mb-1" style="background:#fef2f2;color:#ef4444;font-weight:700">🔥 OFERTA</span><br>
                    <span class="text-muted small" style="text-decoration:line-through">S/. {{ number_format($v->precio, 2) }}</span>
                    <p class="fw-bold fs-5 mb-0" style="color:#ef4444">S/. {{ number_format($v->precio_oferta, 2) }}</p>
                @else
                    <p class="fw-bold fs-5 mb-0" style="color:#059669">S/. {{ number_format($v->precio, 2) }}</p>
                @endif
            </div>
            <div class="card-footer bg-white border-0 px-4 pb-4 pt-2 d-flex gap-2">
                <a href="{{ route('usuario.vehiculos.show', $v) }}" class="btn btn-outline-dark btn-sm rounded-3 flex-fill">
                    <i class="bi bi-eye me-1"></i>Ver detalle
                </a>
                @if($v->stock > 0)
                <form action="{{ route('usuario.carrito.agregar', $v) }}" method="POST" class="flex-fill">
                    @csrf
                    <button class="btn btn-dark btn-sm rounded-3 w-100">
                        <i class="bi bi-cart-plus me-1"></i>Agregar
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif
@endsection