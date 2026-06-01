@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header bg-warning"><h5 class="mb-0">Editar Vehículo</h5></div>
            <div class="card-body">
                <form action="{{ route('admin.vehiculos.update', $vehiculo) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Modelo *</label>
                        <input type="text" name="modelo" class="form-control @error('modelo') is-invalid @enderror"
                            value="{{ old('modelo', $vehiculo->modelo) }}">
                        @error('modelo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Año *</label>
                            <input type="number" name="anio" class="form-control @error('anio') is-invalid @enderror"
                                value="{{ old('anio', $vehiculo->anio) }}" min="1900" max="2099">
                            @error('anio')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Precio *</label>
                            <input type="number" name="precio" step="0.01" class="form-control @error('precio') is-invalid @enderror"
                                value="{{ old('precio', $vehiculo->precio) }}" min="0">
                            @error('precio')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Stock *</label>
                        <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" 
                            value="{{ old('stock', $vehiculo->stock ?? 10) }}" min="0">
                        @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kilometraje *</label>
                        <input type="number" name="kilometraje" class="form-control @error('kilometraje') is-invalid @enderror"
                            value="{{ old('kilometraje', $vehiculo->kilometraje) }}" min="0">
                        @error('kilometraje')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Marca *</label>
                        <select name="marca_id" class="form-select @error('marca_id') is-invalid @enderror">
                            @foreach($marcas as $marca)
                                <option value="{{ $marca->id }}" {{ $vehiculo->marca_id == $marca->id ? 'selected' : '' }}>
                                    {{ $marca->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('marca_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Foto actual:</label><br>
                        @if($vehiculo->foto)
                            <img src="{{ asset('storage/' . $vehiculo->foto) }}" height="80" class="mb-2 rounded">
                        @else
                            <span class="text-muted">Sin foto</span>
                        @endif
                        <input type="file" name="foto" class="form-control mt-2 @error('foto') is-invalid @enderror" accept="image/*">
                        @error('foto')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning">Actualizar</button>
                        <a href="{{ route('admin.vehiculos.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection