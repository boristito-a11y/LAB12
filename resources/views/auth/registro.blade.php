<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cuenta — AutoPremium</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'DM Sans', sans-serif; min-height: 100vh; display: flex; background: #0b0c10; overflow: hidden; }
        .login-visual { flex: 1; position: relative; display: flex; flex-direction: column; justify-content: flex-end; padding: 3rem; background: linear-gradient(160deg, #0b0c10 0%, #12131a 40%, #1a1a2e 100%); overflow: hidden; }
        .login-visual::before { content: ''; position: absolute; width: 520px; height: 520px; border-radius: 50%; background: radial-gradient(circle, rgba(245,158,11,0.18) 0%, transparent 70%); top: -120px; left: -80px; }
        .visual-brand { font-family: 'Syne', sans-serif; font-size: 2.8rem; font-weight: 800; color: #fff; line-height: 1; margin-bottom: 1rem; position: relative; z-index: 1; }
        .visual-brand span { color: #f59e0b; }
        .visual-tagline { font-size: 1.05rem; color: rgba(255,255,255,0.45); position: relative; z-index: 1; max-width: 340px; line-height: 1.6; }
        .login-form-side { width: 460px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; background: #ffffff; padding: 3rem 2.5rem; overflow-y: auto; }
        .form-inner { width: 100%; max-width: 380px; animation: slideUp .5s cubic-bezier(.22,1,.36,1) both; }
        @keyframes slideUp { from { opacity: 0; transform: translateY(24px); } to { opacity: 1; transform: translateY(0); } }
        .form-title { font-family: 'Syne', sans-serif; font-size: 1.8rem; font-weight: 800; color: #0b0c10; margin-bottom: .4rem; }
        .field-label { display: block; font-size: .8rem; font-weight: 600; color: #374151; margin-bottom: .45rem; }
        .field-wrap { position: relative; margin-bottom: 1.1rem; }
        .field-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #9ca3af; pointer-events: none; }
        .field-input { width: 100%; padding: .85rem 1rem .85rem 2.6rem; border: 1.5px solid #e5e7eb; border-radius: 12px; font-family: 'DM Sans', sans-serif; font-size: .95rem; color: #111827; background: #f9fafb; outline: none; transition: all .2s; }
        .field-input:focus { border-color: #f59e0b; background: #fff; box-shadow: 0 0 0 4px rgba(245,158,11,.1); }
        .field-input.is-invalid { border-color: #ef4444; background: #fff5f5; }
        .error-msg { font-size: .78rem; color: #ef4444; margin-top: .3rem; }
        .btn-login { width: 100%; padding: .95rem; background: linear-gradient(135deg, #1a1a2e, #0f0f1a); color: white; border: none; border-radius: 12px; font-family: 'DM Sans', sans-serif; font-size: 1rem; font-weight: 600; cursor: pointer; transition: all .15s; margin-top: .5rem; }
        .btn-login:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(15,15,26,.35); }
        @media (max-width: 768px) { .login-visual { display: none; } .login-form-side { width: 100%; } }
    </style>
</head>
<body>
<div class="login-visual">
    <div class="visual-brand">Auto<span>Premium</span></div>
    <p class="visual-tagline">Creá tu cuenta y empezá a explorar nuestra flota de vehículos premium.</p>
</div>
<div class="login-form-side">
    <div class="form-inner">
        <p style="font-size:.78rem;font-weight:600;letter-spacing:.12em;text-transform:uppercase;color:#f59e0b;margin-bottom:.75rem">
            <i class="bi bi-person-plus me-1"></i>Nueva cuenta
        </p>
        <h1 class="form-title">Crear cuenta</h1>
        <p style="font-size:.9rem;color:#9ca3af;margin-bottom:2rem">Completá tus datos para registrarte.</p>

        <form action="{{ route('registro.post') }}" method="POST" novalidate>
            @csrf
            <div>
                <label class="field-label">Nombre completo</label>
                <div class="field-wrap">
                    <input type="text" name="name" class="field-input @error('name') is-invalid @enderror"
                           value="{{ old('name') }}" placeholder="Tu nombre">
                    <i class="bi bi-person field-icon"></i>
                </div>
                @error('name')<p class="error-msg"><i class="bi bi-exclamation-circle-fill me-1"></i>{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="field-label">Correo electrónico</label>
                <div class="field-wrap">
                    <input type="email" name="email" class="field-input @error('email') is-invalid @enderror"
                           value="{{ old('email') }}" placeholder="correo@ejemplo.com">
                    <i class="bi bi-envelope field-icon"></i>
                </div>
                @error('email')<p class="error-msg"><i class="bi bi-exclamation-circle-fill me-1"></i>{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="field-label">Contraseña</label>
                <div class="field-wrap">
                    <input type="password" name="password" class="field-input @error('password') is-invalid @enderror"
                           placeholder="Mínimo 8 caracteres">
                    <i class="bi bi-lock field-icon"></i>
                </div>
                @error('password')<p class="error-msg"><i class="bi bi-exclamation-circle-fill me-1"></i>{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="field-label">Confirmar contraseña</label>
                <div class="field-wrap">
                    <input type="password" name="password_confirmation" class="field-input"
                           placeholder="Repetí tu contraseña">
                    <i class="bi bi-lock-fill field-icon"></i>
                </div>
            </div>
            <button type="submit" class="btn-login">
                <i class="bi bi-person-check me-2"></i>Crear cuenta
            </button>
        </form>

        <p class="text-center mt-4" style="font-size:.88rem;color:#9ca3af">
            ¿Ya tenés cuenta?
            <a href="{{ route('login') }}" style="color:#f59e0b;font-weight:600;text-decoration:none">Iniciar sesión</a>
        </p>
    </div>
</div>
</body>
</html>