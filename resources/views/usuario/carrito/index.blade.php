@extends('layouts.app')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-0" style="color:#1a1a2e">Mi Carrito</h2>
        <p class="text-muted small mb-0">
            @php $totalItems = collect($carrito)->sum('cantidad'); @endphp
            {{ $totalItems }} {{ $totalItems == 1 ? 'vehículo' : 'vehículos' }} seleccionado{{ $totalItems == 1 ? '' : 's' }}
        </p>
    </div>
    @if(!empty($carrito))
    <form action="{{ route('usuario.carrito.vaciar') }}" method="POST"
          onsubmit="return confirm('¿Vaciar el carrito completo?')">
        @csrf @method('DELETE')
        <button class="btn btn-outline-danger btn-sm rounded-3">
            <i class="bi bi-trash me-1"></i>Vaciar carrito
        </button>
    </form>
    @endif
</div>

@if(empty($carrito))
    <div class="card border-0 rounded-4 shadow-sm text-center p-5">
        <div style="font-size:4rem;color:#d1d5db"><i class="bi bi-cart3"></i></div>
        <h4 class="mt-3 fw-bold" style="color:#1a1a2e">Tu carrito está vacío</h4>
        <p class="text-muted">Explorá nuestro catálogo y agregá vehículos.</p>
        <a href="{{ route('usuario.vehiculos.index') }}" class="btn btn-dark rounded-3 mt-2 px-4">
            <i class="bi bi-grid-3x3-gap me-1"></i>Ver catálogo
        </a>
    </div>
@else
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 rounded-4 shadow-sm overflow-hidden">
            @foreach($carrito as $id => $item)
            <div class="d-flex align-items-center gap-3 p-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                {{-- Foto --}}
                <div style="width:90px;height:65px;border-radius:10px;overflow:hidden;background:#e8eaf0;flex-shrink:0">
                    @if($item['foto'])
                        <img src="{{ asset('storage/' . $item['foto']) }}"
                             style="width:100%;height:100%;object-fit:cover"
                             onerror="this.style.display='none';this.nextElementSibling.style.display='flex'"
                             alt="">
                        <div style="display:none;width:100%;height:100%;align-items:center;justify-content:center;color:#9ca3af;font-size:1.5rem">
                            <i class="bi bi-car-front"></i>
                        </div>
                    @else
                        <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:#9ca3af;font-size:1.5rem">
                            <i class="bi bi-car-front"></i>
                        </div>
                    @endif
                </div>

                {{-- Nombre y precio --}}
                <div class="flex-grow-1">
                    <p class="fw-bold mb-0" style="color:#1a1a2e">{{ $item['nombre'] }}</p>
                    @if($item['en_oferta'])
                        <span class="text-muted small" style="text-decoration:line-through">S/. {{ number_format($item['precio_normal'], 2) }}</span>
                        <p class="small mb-0 fw-semibold" style="color:#ef4444">S/. {{ number_format($item['precio'], 2) }} c/u 🔥</p>
                    @else
                        <p class="text-muted small mb-0">S/. {{ number_format($item['precio'], 2) }} c/u</p>
                    @endif
                </div>

                {{-- Cantidad --}}
                <div class="d-flex align-items-center gap-2">
                    <form action="{{ route('usuario.carrito.decrementar', $id) }}" method="POST">
                        @csrf
                        <button class="btn btn-light btn-sm rounded-circle" style="width:30px;height:30px;padding:0;line-height:1">−</button>
                    </form>
                    <span class="fw-bold" style="min-width:20px;text-align:center">{{ $item['cantidad'] }}</span>
                    <form action="{{ route('usuario.carrito.incrementar', $id) }}" method="POST">
                        @csrf
                        <button class="btn btn-light btn-sm rounded-circle" style="width:30px;height:30px;padding:0;line-height:1">+</button>
                    </form>
                </div>

                {{-- Subtotal --}}
                <div style="min-width:110px;text-align:right">
                    <p class="fw-bold mb-0" style="color:#059669">S/. {{ number_format($item['precio'] * $item['cantidad'], 2) }}</p>
                </div>

                {{-- Eliminar --}}
                <form action="{{ route('usuario.carrito.eliminar', $id) }}" method="POST">
                    @csrf @method('DELETE')
                    <button class="btn btn-light btn-sm rounded-3" style="color:#ef4444" title="Eliminar">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </form>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Resumen --}}
    <div class="col-lg-4">
        <div class="card border-0 rounded-4 shadow-sm p-4 sticky-top" style="top:90px">
            <h5 class="fw-bold mb-3" style="color:#1a1a2e">Resumen del pedido</h5>

            @foreach($carrito as $item)
            <div class="d-flex justify-content-between small text-muted mb-1">
                <span>{{ $item['nombre'] }} x{{ $item['cantidad'] }}</span>
                <span>S/. {{ number_format($item['precio'] * $item['cantidad'], 2) }}</span>
            </div>
            @endforeach

            <hr class="my-3">

            <div class="d-flex justify-content-between fw-bold fs-5 mb-4">
                <span>Total</span>
                <span style="color:#059669">S/. {{ number_format($total, 2) }}</span>
            </div>

            <button class="btn btn-dark w-100 rounded-3 py-2 fw-semibold"
                    onclick="document.getElementById('modalCompra').style.display='flex'">
                <i class="bi bi-credit-card me-2"></i>Realizar compra
            </button>
            <a href="{{ route('usuario.vehiculos.index') }}" class="btn btn-light w-100 rounded-3 py-2 mt-2">
                ← Seguir comprando
            </a>
        </div>
    </div>
</div>

{{-- Modal confirmación --}}
<div id="modalCompra" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.6);z-index:9999;align-items:center;justify-content:center">
    <div class="bg-white rounded-4 p-5 text-center shadow-lg" style="max-width:420px;width:90%">
        <div style="font-size:3rem;color:#f59e0b"><i class="bi bi-credit-card"></i></div>
        <h3 class="fw-bold mt-2" style="color:#1a1a2e">Confirmar Compra</h3>
        <p class="text-muted">Vas a pagar un total de:</p>
        <p class="fw-bold fs-3" style="color:#059669">S/. {{ number_format($total, 2) }}</p>

        <div class="d-flex gap-2 justify-content-center mt-3">
            
            <button type="button"
                    class="btn btn-light rounded-3 px-4"
                    onclick="document.getElementById('modalCompra').style.display='none'">
                Cancelar
            </button>

            <form action="{{ route('usuario.carrito.comprar') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-dark">
                    Confirmar pago
                </button>
            </form>

        </div>
    </div>
</div>
@endif
@endsection