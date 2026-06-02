@extends('layouts.app')
@section('content')

<div class="row justify-content-center">
    <div class="col-md-7">

        {{-- Header perfil --}}
        <div class="card border-0 rounded-4 shadow-sm mb-4 overflow-hidden">
            <div style="height:80px;background:linear-gradient(135deg,#1a1a2e,#16213e)"></div>
            <div class="card-body px-4 pb-4" style="margin-top:-30px">
                <div class="d-flex align-items-end gap-3 mb-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white"
                         style="width:60px;height:60px;background:#f59e0b;font-size:1.5rem;border:3px solid white;flex-shrink:0">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0" style="color:#1a1a2e">{{ auth()->user()->name }}</h4>
                        <p class="text-muted small mb-0">{{ auth()->user()->email }}
                            &nbsp;·&nbsp;
                            <span class="badge rounded-3" style="background:{{ auth()->user()->esAdmin() ? '#1a1a2e' : '#ecfdf5' }};color:{{ auth()->user()->esAdmin() ? 'white' : '#065f46' }}">
                                {{ auth()->user()->esAdmin() ? 'Administrador' : 'Usuario' }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Actualizar nombre --}}
        <div class="card border-0 rounded-4 shadow-sm mb-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4" style="color:#1a1a2e">
                    <i class="bi bi-person me-2" style="color:#f59e0b"></i>Información personal
                </h5>
                <form action="{{ route('perfil.nombre') }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label fw-semibold small text-muted">NOMBRE COMPLETO</label>
                        <input type="text" name="name"
                               class="form-control rounded-3 @error('name') is-invalid @enderror"
                               value="{{ old('name', auth()->user()->name) }}"
                               style="background:#f8fafc;border:1.5px solid #e2e8f0;padding:.75rem 1rem">
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold small text-muted">CORREO ELECTRÓNICO</label>
                        <input type="email" class="form-control rounded-3"
                               value="{{ auth()->user()->email }}" disabled
                               style="background:#f0f2f5;border:1.5px solid #e2e8f0;padding:.75rem 1rem">
                        <small class="text-muted">El correo no puede modificarse.</small>
                    </div>
                    <button type="submit" class="btn btn-dark rounded-3 px-4 fw-semibold">
                        <i class="bi bi-check-lg me-2"></i>Guardar cambios
                    </button>
                </form>
            </div>
        </div>

        {{-- Cambiar contraseña --}}
        <div class="card border-0 rounded-4 shadow-sm">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4" style="color:#1a1a2e">
                    <i class="bi bi-shield-lock me-2" style="color:#f59e0b"></i>Seguridad
                </h5>
                <form action="{{ route('perfil.password') }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label fw-semibold small text-muted">CONTRASEÑA ACTUAL</label>
                        <input type="password" name="password_actual"
                               class="form-control rounded-3 @error('password_actual') is-invalid @enderror"
                               style="background:#f8fafc;border:1.5px solid #e2e8f0;padding:.75rem 1rem">
                        @error('password_actual')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small text-muted">NUEVA CONTRASEÑA</label>
                        <input type="password" name="password_nuevo"
                               class="form-control rounded-3 @error('password_nuevo') is-invalid @enderror"
                               style="background:#f8fafc;border:1.5px solid #e2e8f0;padding:.75rem 1rem">
                        @error('password_nuevo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold small text-muted">CONFIRMAR NUEVA CONTRASEÑA</label>
                        <input type="password" name="password_nuevo_confirmation"
                               class="form-control rounded-3"
                               style="background:#f8fafc;border:1.5px solid #e2e8f0;padding:.75rem 1rem">
                    </div>
                    <button type="submit" class="btn rounded-3 px-4 fw-semibold"
                            style="background:#1a1a2e;color:white">
                        <i class="bi bi-lock me-2"></i>Cambiar contraseña
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection