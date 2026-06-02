@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header bg-dark text-white"><h5 class="mb-0">Nuevo Vehículo</h5></div>
            <div class="card-body">
                <form action="{{ route('admin.vehiculos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Modelo *</label>
                        <input type="text" name="modelo" class="form-control @error('modelo') is-invalid @enderror"
                            value="{{ old('modelo') }}">
                        @error('modelo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Año *</label>
                            <input type="number" name="anio" class="form-control @error('anio') is-invalid @enderror"
                                value="{{ old('anio') }}" min="1900" max="2099">
                            @error('anio')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Precio (S/.) *</label>
                            <input type="number" name="precio" step="0.01" class="form-control @error('precio') is-invalid @enderror"
                                value="{{ old('precio') }}" min="0">
                            @error('precio')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Stock *</label>
                        <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror"
                            value="{{ old('stock', 10) }}" min="0">
                        @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kilometraje *</label>
                        <input type="number" name="kilometraje" class="form-control @error('kilometraje') is-invalid @enderror"
                            value="{{ old('kilometraje') }}" min="0">
                        @error('kilometraje')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Marca *</label>
                        <select name="marca_id" class="form-select @error('marca_id') is-invalid @enderror">
                            <option value="">-- Selecciona una marca --</option>
                            @foreach($marcas as $marca)
                                <option value="{{ $marca->id }}" {{ old('marca_id') == $marca->id ? 'selected' : '' }}>
                                    {{ $marca->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('marca_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Foto (jpg, jpeg, png, gif)</label>
                        <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/*">
                        @error('foto')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    {{-- OFERTA --}}
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="en_oferta" id="en_oferta" value="1"
                                   onchange="document.getElementById('campoOferta').style.display=this.checked?'block':'none'">
                            <label class="form-check-label fw-semibold" for="en_oferta">🔥 Marcar como oferta</label>
                        </div>
                    </div>
                    <div class="mb-3" id="campoOferta" style="display:none">
                        <label class="form-label">Precio de oferta (S/.)</label>
                        <input type="number" name="precio_oferta" step="0.01" min="0" class="form-control rounded-3">
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-dark">Guardar</button>
                        <a href="{{ route('admin.vehiculos.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection