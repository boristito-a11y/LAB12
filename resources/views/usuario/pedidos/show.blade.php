@extends('layouts.app')
@section('content')

<a href="{{ route('usuario.pedidos.index') }}" class="btn btn-light btn-sm rounded-3 mb-4">
    <i class="bi bi-arrow-left me-1"></i>Mis compras
</a>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card border-0 rounded-4 shadow-sm overflow-hidden">

            {{-- Header --}}
            <div class="p-4" style="background:#1a1a2e">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-white opacity-75 small mb-0">Pedido</p>
                        <h4 class="text-white fw-bold mb-0">#{{ $pedido->id }}</h4>
                    </div>
                    <span class="badge rounded-3 px-3 py-2" style="background:#ecfdf5;color:#065f46;font-weight:600">
                        <i class="bi bi-check-circle-fill me-1"></i>Completado
                    </span>
                </div>
                <p class="text-white opacity-50 small mt-2 mb-0">
                    <i class="bi bi-calendar3 me-1"></i>{{ $pedido->created_at->format('d \d\e F \d\e Y, H:i') }}
                </p>
            </div>

            <div class="card-body p-4">
                {{-- Items --}}
                <h6 class="fw-bold mb-3" style="color:#6b7280;letter-spacing:.05em">VEHÍCULOS COMPRADOS</h6>
                <div class="d-flex flex-column gap-2 mb-4">
                    @foreach($pedido->items as $item)
                    <div class="d-flex justify-content-between align-items-center p-3 rounded-3" style="background:#f8fafc">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-3 d-flex align-items-center justify-content-center"
                                 style="width:42px;height:42px;background:#e8eaf0;color:#9ca3af;font-size:1.2rem">
                                <i class="bi bi-car-front"></i>
                            </div>
                            <div>
                                <p class="fw-semibold mb-0" style="color:#1a1a2e">{{ $item->modelo }}</p>
                                <p class="text-muted small mb-0">{{ $item->marca }} · S/. {{ number_format($item->precio, 2) }} c/u</p>
                            </div>
                        </div>
                        <div class="text-end">
                            <p class="fw-bold mb-0" style="color:#059669">S/. {{ number_format($item->precio * $item->cantidad, 2) }}</p>
                            <p class="text-muted small mb-0">Cantidad: {{ $item->cantidad }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Total --}}
                <div class="d-flex justify-content-between align-items-center p-4 rounded-3"
                     style="background:linear-gradient(135deg,#1a1a2e,#0f0f1a)">
                    <span class="text-white opacity-75 fw-semibold">Total pagado</span>
                    <span class="fw-bold fs-4" style="color:#f59e0b">S/. {{ number_format($pedido->total, 2) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection