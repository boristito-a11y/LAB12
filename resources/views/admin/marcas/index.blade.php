@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>📋 Marcas</h2>
    <a href="{{ route('admin.marcas.create') }}" class="btn btn-dark">+ Nueva Marca</a>
</div>
<div class="card">
    <div class="card-body">
        <table class="table table-hover">
            <thead class="table-dark">
                <tr><th>#</th><th>Nombre</th><th>País de Origen</th><th>Acciones</th></tr>
            </thead>
            <tbody>
                @foreach($marcas as $marca)
                <tr>
                    <td>{{ $marca->id }}</td>
                    <td>{{ $marca->nombre }}</td>
                    <td>{{ $marca->pais_origen }}</td>
                    <td>
                        <a href="{{ route('admin.marcas.edit', $marca) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('admin.marcas.destroy', $marca) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar esta marca?')">
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