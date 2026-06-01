@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>🚗 Vehículos</h2>
    <a href="{{ route('admin.vehiculos.create') }}" class="btn btn-dark">+ Nuevo Vehículo</a>
</div>
<div class="card">
    <div class="card-body">
        <table class="table table-hover">
            <thead class="table-dark">
                <tr><th>Foto</th><th>Modelo</th><th>Marca</th><th>Año</th><th>Precio</th><th>Km</th><th>Acciones</th></tr>
            </thead>
            <tbody>
                @foreach($vehiculos as $v)
                <tr>
                    <td>
                        @if($v->foto)
                            <img src="{{ asset('storage/' . $v->foto) }}" width="60" height="45" style="object-fit:cover; border-radius:5px">
                        @else
                            <span class="text-muted">Sin foto</span>
                        @endif
                    </td>
                    <td>{{ $v->modelo }}</td>
                    <td>{{ $v->marca->nombre }}</td>
                    <td>{{ $v->anio }}</td>
                    <td>S/. {{ number_format($v->precio, 2) }}</td>
                    <td>{{ number_format($v->kilometraje) }} km</td>
                    <td>
                        <a href="{{ route('admin.vehiculos.show', $v) }}" class="btn btn-sm btn-info">Ver</a>
                        <a href="{{ route('admin.vehiculos.edit', $v) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('admin.vehiculos.destroy', $v) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar este vehículo?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection