@extends('layouts.app')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-0" style="color:#1a1a2e">Gestión de Vehículos</h2>
        <p class="text-muted small mb-0">{{ $vehiculos->count() }} vehículos registrados</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.vehiculos.pdf') }}" class="btn btn-outline-dark rounded-3 px-4 fw-semibold">
            <i class="bi bi-file-earmark-pdf me-2"></i>Exportar PDF
        </a>
        <a href="{{ route('admin.vehiculos.create') }}" class="btn btn-dark rounded-3 px-4 fw-semibold">
            <i class="bi bi-plus-lg me-2"></i>Nuevo Vehículo
        </a>
    </div>
</div>

<div class="card border-0 rounded-4 shadow-sm overflow-hidden">
    <table class="table table-hover align-middle mb-0">
        <thead style="background:#1a1a2e; color:white;">
            <tr>
                <th class="ps-4 py-3">Vehículo</th>
                <th>Marca</th>
                <th>Año</th>
                <th>Precio</th>
                <th>Kilometraje</th>
                <th>Stock</th>
                <th class="text-center pe-4">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($vehiculos as $v)
            <tr style="border-bottom:1px solid #f0f2f5">
                <td class="ps-4 py-3">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width:70px;height:50px;border-radius:10px;overflow:hidden;background:#e8eaf0;flex-shrink:0">
                            @if($v->foto)
                                <img src="{{ asset('storage/' . $v->foto) }}"
                                     style="width:100%;height:100%;object-fit:cover"
                                     onerror="this.parentElement.innerHTML='<div style=\'width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:#9ca3af\'><i class=\'bi bi-car-front\'></i></div>'">
                            @else
                                <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:#9ca3af;font-size:1.3rem">
                                    <i class="bi bi-car-front"></i>
                                </div>
                            @endif
                        </div>
                        <span class="fw-semibold" style="color:#1a1a2e">{{ $v->modelo }}</span>
                    </div>
                </td>
                <td><span class="badge rounded-3 px-3 py-2" style="background:#f0f2f5;color:#374151;font-weight:600">{{ $v->marca->nombre }}</span></td>
                <td class="text-muted">{{ $v->anio }}</td>
                <td class="fw-semibold" style="color:#059669">S/. {{ number_format($v->precio, 2) }}</td>
                <td class="text-muted">{{ number_format($v->kilometraje) }} km</td>
                <td>{!! $v->badgeStock() !!}</td>
                <td class="text-center pe-4">
                    <div class="d-flex justify-content-center gap-2">
                        <a href="{{ route('admin.vehiculos.show', $v) }}"
                           class="btn btn-sm rounded-3 px-3" style="background:#eff6ff;color:#3b82f6;font-weight:500">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('admin.vehiculos.edit', $v) }}"
                           class="btn btn-sm rounded-3 px-3" style="background:#fffbeb;color:#d97706;font-weight:500">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.vehiculos.destroy', $v) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar {{ $v->modelo }}? Esta acción no se puede deshacer.')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm rounded-3 px-3" style="background:#fef2f2;color:#ef4444;font-weight:500;border:none">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center py-5 text-muted">
                    <i class="bi bi-car-front" style="font-size:2.5rem;display:block;margin-bottom:.5rem"></i>
                    No hay vehículos registrados aún.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection