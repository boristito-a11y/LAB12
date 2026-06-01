@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-warning"><h5 class="mb-0">Editar Marca</h5></div>
            <div class="card-body">
                <form action="{{ route('admin.marcas.update', $marca) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Nombre *</label>
                        <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                            value="{{ old('nombre', $marca->nombre) }}">
                        @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">País de Origen *</label>
                        <input type="text" name="pais_origen" class="form-control @error('pais_origen') is-invalid @enderror"
                            value="{{ old('pais_origen', $marca->pais_origen) }}">
                        @error('pais_origen')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning">Actualizar</button>
                        <a href="{{ route('admin.marcas.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection