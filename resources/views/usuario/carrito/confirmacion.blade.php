@extends('layouts.app')
@section('content')

<style>
.confirm-wrap {
    min-height: 72vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem 1rem;
}

.confirm-card {
    background: white;
    border-radius: 24px;
    padding: 3rem 2.5rem;
    max-width: 540px;
    width: 100%;
    box-shadow: 0 20px 60px rgba(0,0,0,0.10);
    text-align: center;
    animation: popIn .5s cubic-bezier(.22,1,.36,1) both;
}

@keyframes popIn {
    from { opacity:0; transform: scale(.94) translateY(20px); }
    to   { opacity:1; transform: scale(1) translateY(0); }
}

.confirm-check {
    width: 80px; height: 80px;
    background: linear-gradient(135deg, #ecfdf5, #d1fae5);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 2.4rem;
    color: #059669;
    box-shadow: 0 8px 24px rgba(5,150,105,.15);
}

.confirm-title {
    font-size: 1.75rem;
    font-weight: 800;
    color: #0b0c10;
    margin-bottom: .4rem;
}

.confirm-sub {
    color: #6b7280;
    font-size: .95rem;
    margin-bottom: 2rem;
}

.confirm-items {
    background: #f8fafc;
    border-radius: 16px;
    padding: 1.25rem 1.5rem;
    margin-bottom: 1.5rem;
    text-align: left;
}

.confirm-item-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: .55rem 0;
    border-bottom: 1px solid #e5e7eb;
    font-size: .9rem;
    color: #374151;
}

.confirm-item-row:last-child { border-bottom: none; }

.confirm-item-name {
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: .5rem;
}

.confirm-item-name i { color: #9ca3af; font-size: .85rem; }

.confirm-total-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 1.5rem;
    background: linear-gradient(135deg, #0f0f1a, #1a1a2e);
    border-radius: 14px;
    margin-bottom: 1.5rem;
    color: white;
}

.confirm-total-label {
    font-size: .9rem;
    font-weight: 500;
    opacity: .75;
}

.confirm-total-amount {
    font-size: 1.6rem;
    font-weight: 800;
    color: #f59e0b;
}

.confirm-message {
    font-size: .88rem;
    color: #9ca3af;
    margin-bottom: 2rem;
    line-height: 1.6;
}

.confirm-message strong { color: #374151; }

.btn-back {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    background: linear-gradient(135deg, #1a1a2e, #0f0f1a);
    color: white;
    padding: .9rem 2.25rem;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    font-size: .95rem;
    transition: transform .15s, box-shadow .15s;
}

.btn-back:hover {
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(15,15,26,.35);
}

.order-badge {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    background: #fffbeb;
    color: #92400e;
    border: 1px solid #fde68a;
    border-radius: 99px;
    padding: .35rem 1rem;
    font-size: .78rem;
    font-weight: 600;
    margin-bottom: 1.75rem;
}
</style>

<div class="confirm-wrap">
    <div class="confirm-card">

        <div class="confirm-check">
            <i class="bi bi-check-lg"></i>
        </div>

        <span class="order-badge">
            <i class="bi bi-receipt"></i>
            Orden confirmada
        </span>

        <h1 class="confirm-title">¡Compra realizada!</h1>
        <p class="confirm-sub">Tu pago fue procesado exitosamente.</p>

        {{-- Detalle de items --}}
        <div class="confirm-items">
            @foreach($carrito as $item)
            <div class="confirm-item-row">
                <span class="confirm-item-name">
                    <i class="bi bi-car-front"></i>
                    {{ $item['nombre'] }}
                    <span style="color:#9ca3af;font-size:.8rem">×{{ $item['cantidad'] }}</span>
                </span>
                <span style="font-weight:600;color:#059669">
                    S/. {{ number_format($item['precio'] * $item['cantidad'], 2) }}
                </span>
            </div>
            @endforeach
        </div>

        {{-- Total --}}
        <div class="confirm-total-row">
            <span class="confirm-total-label">
                <i class="bi bi-credit-card me-1"></i>Total pagado
            </span>
            <span class="confirm-total-amount">S/. {{ number_format($total, 2) }}</span>
        </div>

        <p class="confirm-message">
            Nos comunicaremos con vos para coordinar la <strong>entrega de tu vehículo</strong>.<br>
            Gracias por elegir <strong>AutoPremium</strong>.
        </p>

        <a href="{{ route('usuario.vehiculos.index') }}" class="btn-back">
            <i class="bi bi-grid-3x3-gap"></i>
            Seguir explorando
        </a>

    </div>
</div>

@endsection