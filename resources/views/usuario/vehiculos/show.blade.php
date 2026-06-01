@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <a href="{{ route('usuario.vehiculos.index') }}" class="btn btn-light btn-sm rounded-3 mb-3">
            <i class="bi bi-arrow-left me-1"></i>Volver al catálogo
        </a>
        <div class="card border-0 rounded-4 shadow-sm overflow-hidden">
            <div class="row g-0">
                {{-- Imagen --}}
                <div class="col-md-6" style="background:#e8eaf0;min-height:350px;display:flex;align-items:center;justify-content:center">
                    @if($vehiculo->foto)
                        <img src="{{ asset('storage/' . $vehiculo->foto) }}"
                             style="width:100%;height:100%;object-fit:cover;min-height:350px;object-position:center"
                             onerror="this.style.display='none';this.nextElementSibling.style.display='flex'"
                             alt="{{ $vehiculo->modelo }}">
                        <div style="display:none;width:100%;height:350px;align-items:center;justify-content:center;font-size:5rem;color:#9ca3af">
                            <i class="bi bi-car-front"></i>
                        </div>
                    @else
                        <div style="font-size:5rem;color:#9ca3af"><i class="bi bi-car-front"></i></div>
                    @endif
                </div>

                {{-- Info --}}
                <div class="col-md-6 d-flex flex-column">
                    <div class="card-body p-4 flex-grow-1">
                        <p class="text-muted small fw-semibold mb-1" style="letter-spacing:.5px">
                            {{ strtoupper($vehiculo->marca->nombre) }} · {{ $vehiculo->anio }}
                        </p>
                        <h2 class="fw-bold mb-1" style="color:#1a1a2e">{{ $vehiculo->modelo }}</h2>
                        <div class="mb-3">{!! $vehiculo->badgeStock() !!}</div>

                        <div class="mb-4">
                            <p class="fs-2 fw-bold mb-0" style="color:#059669">S/. {{ number_format($vehiculo->precio, 2) }}</p>
                        </div>

                        <div class="row g-2 mb-4">
                            <div class="col-6">
                                <div class="bg-light rounded-3 p-3 text-center">
                                    <p class="text-muted small mb-0">Kilometraje</p>
                                    <p class="fw-bold mb-0">{{ number_format($vehiculo->kilometraje) }} km</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="bg-light rounded-3 p-3 text-center">
                                    <p class="text-muted small mb-0">País de origen</p>
                                    <p class="fw-bold mb-0">{{ $vehiculo->marca->pais_origen }}</p>
                                </div>
                            </div>
                        </div>

                        @if($vehiculo->stock > 0)
                            <form action="{{ route('usuario.carrito.agregar', $vehiculo) }}" method="POST">
                                @csrf
                                <button class="btn btn-dark w-100 rounded-3 py-2 fw-semibold">
                                    <i class="bi bi-cart-plus me-2"></i>Agregar al carrito
                                </button>
                            </form>
                        @else
                            <button class="btn btn-secondary w-100 rounded-3 py-2" disabled>Sin stock disponible</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection