@extends('layouts.app')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-0" style="color:#1a1a2e">Gestión de Marcas</h2>
        <p class="text-muted small mb-0">{{ $marcas->count() }} marcas registradas</p>
    </div>
    <a href="{{ route('admin.marcas.create') }}" class="btn btn-dark rounded-3 px-4 fw-semibold">
        <i class="bi bi-plus-lg me-2"></i>Nueva Marca
    </a>
</div>

<div class="row row-cols-1 row-cols-md-3 g-4">
    @forelse($marcas as $marca)
    <div class="col">
        <div class="card border-0 rounded-4 shadow-sm h-100 p-4">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="rounded-3 d-flex align-items-center justify-content-center"
                     style="width:50px;height:50px;background:#f0f2f5;font-size:1.5rem">
                    🏷️
                </div>
                <span class="badge rounded-3 px-3" style="background:#f0f2f5;color:#6b7280;font-weight:500">
                    {{ $marca->vehiculos->count() }} vehículos
                </span>
            </div>
            <h5 class="fw-bold mb-1" style="color:#1a1a2e">{{ $marca->nombre }}</h5>
            <p class="text-muted small mb-3"><i class="bi bi-geo-alt me-1"></i>{{ $marca->pais_origen }}</p>
            <div class="d-flex gap-2 mt-auto">
                <a href="{{ route('admin.marcas.edit', $marca) }}"
                   class="btn btn-sm rounded-3 flex-fill fw-semibold" style="background:#fffbeb;color:#d97706">
                    <i class="bi bi-pencil me-1"></i>Editar
                </a>
                <form action="{{ route('admin.marcas.destroy', $marca) }}" method="POST"
                      onsubmit="return confirm('¿Eliminar la marca {{ $marca->nombre }}?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm rounded-3 px-3" style="background:#fef2f2;color:#ef4444;border:none">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5 text-muted">No hay marcas registradas.</div>
    @endforelse
</div>
@endsection