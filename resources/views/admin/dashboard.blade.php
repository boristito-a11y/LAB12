@extends('layouts.app')
@section('content')

<div class="mb-4">
    <h2 class="fw-bold mb-0" style="color:#1a1a2e">Panel de Control</h2>
    <p class="text-muted small">Bienvenido, {{ auth()->user()->name }}</p>
</div>

{{-- Tarjetas resumen --}}
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-0 rounded-4 shadow-sm p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted small fw-semibold mb-1">MARCAS</p>
                    <h2 class="fw-bold mb-0" style="color:#1a1a2e">{{ $totalMarcas }}</h2>
                </div>
                <div class="rounded-3 d-flex align-items-center justify-content-center"
                     style="width:52px;height:52px;background:#f0f9ff;font-size:1.5rem">🏷️</div>
            </div>
            <a href="{{ route('admin.marcas.index') }}" class="text-muted small mt-3 d-block text-decoration-none">
                Ver todas <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 rounded-4 shadow-sm p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted small fw-semibold mb-1">VEHÍCULOS</p>
                    <h2 class="fw-bold mb-0" style="color:#1a1a2e">{{ $totalVehiculos }}</h2>
                </div>
                <div class="rounded-3 d-flex align-items-center justify-content-center"
                     style="width:52px;height:52px;background:#f0fdf4;font-size:1.5rem">🚗</div>
            </div>
            <a href="{{ route('admin.vehiculos.index') }}" class="text-muted small mt-3 d-block text-decoration-none">
                Ver todos <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 rounded-4 shadow-sm p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted small fw-semibold mb-1">USUARIOS</p>
                    <h2 class="fw-bold mb-0" style="color:#1a1a2e">{{ $totalUsuarios }}</h2>
                </div>
                <div class="rounded-3 d-flex align-items-center justify-content-center"
                     style="width:52px;height:52px;background:#fefce8;font-size:1.5rem">👤</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 rounded-4 shadow-sm p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted small fw-semibold mb-1">SIN STOCK</p>
                    <h2 class="fw-bold mb-0" style="color:#ef4444">{{ $sinStock }}</h2>
                </div>
                <div class="rounded-3 d-flex align-items-center justify-content-center"
                     style="width:52px;height:52px;background:#fef2f2;font-size:1.5rem">⚠️</div>
            </div>
        </div>
    </div>
</div>

{{-- Gráfica --}}
<div class="card border-0 rounded-4 shadow-sm mb-4">
    <div class="card-body p-4">
        <h5 class="fw-bold mb-1" style="color:#1a1a2e">📊 Vehículos por marca</h5>
        <p class="text-muted small mb-4">Distribución del inventario actual</p>
        <canvas id="graficaMarcas" height="100"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('graficaMarcas').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($ventasPorMarca->pluck('marca')) !!},
        datasets: [{
            label: 'Vehículos',
            data: {!! json_encode($ventasPorMarca->pluck('total_vendidos')) !!},
            backgroundColor: [
                '#1a1a2e','#f59e0b','#059669','#3b82f6','#ef4444',
                '#8b5cf6','#ec4899','#14b8a6','#f97316','#6b7280'
            ],
            borderRadius: 8,
            borderSkipped: false,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, grid: { color: '#f0f2f5' }, ticks: { stepSize: 1 } },
            x: { grid: { display: false } }
        }
    }
});
</script>

{{-- Vehículos recientes --}}
<div class="card border-0 rounded-4 shadow-sm">
    <div class="card-body p-4">
        <h5 class="fw-bold mb-4" style="color:#1a1a2e">Vehículos agregados recientemente</h5>
        <table class="table align-middle mb-0">
            <thead style="color:#6b7280;font-size:.85rem">
                <tr>
                    <th class="fw-semibold border-0">VEHÍCULO</th>
                    <th class="fw-semibold border-0">MARCA</th>
                    <th class="fw-semibold border-0">PRECIO</th>
                    <th class="fw-semibold border-0">STOCK</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recientes as $v)
                <tr style="border-top:1px solid #f0f2f5">
                    <td class="fw-semibold" style="color:#1a1a2e">{{ $v->modelo }}</td>
                    <td class="text-muted">{{ $v->marca->nombre }}</td>
                    <td style="color:#059669;font-weight:600">S/. {{ number_format($v->precio, 2) }}</td>
                    <td>{!! $v->badgeStock() !!}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Alerta de stock bajo --}}
@if($vehiculosBajoStock->count() > 0)
<div class="card border-0 rounded-4 shadow-sm mt-4">
    <div class="card-body p-4">
        <h5 class="fw-bold mb-1" style="color:#1a1a2e">⚠️ Vehículos con stock bajo</h5>
        <p class="text-muted small mb-4">Actualizá el stock directamente desde aquí.</p>
        <div class="d-flex flex-column gap-2">
            @foreach($vehiculosBajoStock as $v)
            <div class="d-flex align-items-center justify-content-between p-3 rounded-3" style="background:#fef2f2">
                <div>
                    <span class="fw-semibold" style="color:#1a1a2e">{{ $v->modelo }}</span>
                    <span class="text-muted small ms-2">{{ $v->marca->nombre }}</span>
                    <span class="badge ms-2" style="background:#fee2e2;color:#ef4444">Stock: {{ $v->stock }}</span>
                </div>
                <form action="{{ route('admin.vehiculos.reajustar', $v) }}" method="POST" class="d-flex gap-2 align-items-center">
                    @csrf @method('PATCH')
                    <input type="number" name="stock" min="0" value="{{ $v->stock }}"
                           class="form-control form-control-sm rounded-3" style="width:80px">
                    <button class="btn btn-sm btn-dark rounded-3">Guardar</button>
                </form>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

@endsection