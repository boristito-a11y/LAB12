@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <!-- Actualizar nombre -->
        <div class="card mb-4">
            <div class="card-header bg-dark text-white"><h5 class="mb-0">👤 Mi Perfil</h5></div>
            <div class="card-body">
                <form action="{{ route('perfil.nombre') }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', auth()->user()->name) }}">
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-2 text-muted small">Correo: {{ auth()->user()->email }}</div>
                    <button type="submit" class="btn btn-dark">Actualizar nombre</button>
                </form>
            </div>
        </div>

        <!-- Cambiar contraseña -->
        <div class="card">
            <div class="card-header bg-secondary text-white"><h5 class="mb-0">🔒 Cambiar Contraseña</h5></div>
            <div class="card-body">
                <form action="{{ route('perfil.password') }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Contraseña actual</label>
                        <input type="password" name="password_actual" class="form-control @error('password_actual') is-invalid @enderror">
                        @error('password_actual')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nueva contraseña</label>
                        <input type="password" name="password_nuevo" class="form-control @error('password_nuevo') is-invalid @enderror">
                        @error('password_nuevo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirmar nueva contraseña</label>
                        <input type="password" name="password_nuevo_confirmation" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-secondary">Cambiar contraseña</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection