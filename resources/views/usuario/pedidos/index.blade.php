@extends('layouts.app')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-0" style="color:#1a1a2e">Mis Compras</h2>
        <p class="text-muted small mb-0">Historial de todos tus pedidos</p>
    </div>
</div>

@if($pedidos->isEmpty())
    <div class="card border-0 rounded-4 shadow-sm text-center p-5">
        <div style="font-size:4rem;color:#d1d5db"><i class="bi bi-bag-x"></i></div>
        <h4 class="mt-3 fw-bold" style="color:#1a1a2e">Aún no tienes compras</h4>
        <p class="text-muted">Explorá el catálogo y realizá tu primera compra.</p>
        <a href="{{ route('usuario.vehiculos.index') }}" class="btn btn-dark rounded-3 px-4 mt-2">
            <i class="bi bi-grid-3x3-gap me-2"></i>Ver catálogo
        </a>
    </div>
@else
    <div class="d-flex flex-column gap-3">
        @foreach($pedidos as $pedido)
        <div class="card border-0 rounded-4 shadow-sm p-4">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                <div>
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <span class="fw-bold" style="color:#1a1a2e">Pedido #{{ $pedido->id }}</span>
                        <span class="badge rounded-3 px-3" style="background:#ecfdf5;color:#065f46;font-weight:600">
                            <i class="bi bi-check-circle-fill me-1"></i>Completado
                        </span>
                    </div>
                    <p class="text-muted small mb-0">
                        <i class="bi bi-calendar3 me-1"></i>{{ $pedido->created_at->format('d/m/Y H:i') }}
                        &nbsp;·&nbsp;
                        <i class="bi bi-box me-1"></i>{{ $pedido->cantidad_items }} {{ $pedido->cantidad_items == 1 ? 'vehículo' : 'vehículos' }}
                    </p>
                </div>
                <div class="text-end">
                    <p class="fw-bold fs-5 mb-1" style="color:#059669">S/. {{ number_format($pedido->total, 2) }}</p>
                    <a href="{{ route('usuario.pedidos.show', $pedido) }}"
                       class="btn btn-sm rounded-3 px-3" style="background:#f0f2f5;color:#374151;font-weight:500">
                        Ver detalle <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>

            {{-- Preview de items --}}
            <div class="mt-3 pt-3" style="border-top:1px solid #f0f2f5">
                <div class="d-flex flex-wrap gap-2">
                    @foreach($pedido->items->take(3) as $item)
                        <span class="badge rounded-3 px-3 py-2" style="background:#f8fafc;color:#374151;font-weight:500">
                            <i class="bi bi-car-front me-1 text-muted"></i>{{ $item->modelo }} {{ $item->marca }}
                            <span class="text-muted">×{{ $item->cantidad }}</span>
                        </span>
                    @endforeach
                    @if($pedido->items->count() > 3)
                        <span class="badge rounded-3 px-3 py-2" style="background:#f8fafc;color:#9ca3af">
                            +{{ $pedido->items->count() - 3 }} más
                        </span>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif
@endsection