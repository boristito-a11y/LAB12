<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión — AutoPremium</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            background: #0b0c10;
            overflow: hidden;
        }

        /* Panel izquierdo — visual */
        .login-visual {
            flex: 1;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 3rem;
            background: linear-gradient(160deg, #0b0c10 0%, #12131a 40%, #1a1a2e 100%);
            overflow: hidden;
        }

        /* Círculos decorativos de fondo */
        .login-visual::before {
            content: '';
            position: absolute;
            width: 520px; height: 520px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(245,158,11,0.18) 0%, transparent 70%);
            top: -120px; left: -80px;
            pointer-events: none;
        }
        .login-visual::after {
            content: '';
            position: absolute;
            width: 380px; height: 380px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(99,102,241,0.15) 0%, transparent 70%);
            bottom: 60px; right: -80px;
            pointer-events: none;
        }

        .visual-brand {
            font-family: 'Syne', sans-serif;
            font-size: 2.8rem;
            font-weight: 800;
            color: #fff;
            line-height: 1;
            margin-bottom: 1rem;
            position: relative; z-index: 1;
        }
        .visual-brand span { color: #f59e0b; }

        .visual-tagline {
            font-size: 1.05rem;
            color: rgba(255,255,255,0.45);
            font-weight: 400;
            position: relative; z-index: 1;
            max-width: 340px;
            line-height: 1.6;
        }

        /* Grid de autos decorativo */
        .car-grid {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -54%);
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
            opacity: 0.06;
            z-index: 0;
        }
        .car-grid-item {
            font-size: 4.5rem;
            color: white;
            text-align: center;
        }

        /* Panel derecho — formulario */
        .login-form-side {
            width: 440px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
            padding: 3rem 2.5rem;
            position: relative;
        }

        .form-inner { width: 100%; max-width: 360px; }

        .form-eyebrow {
            font-size: .78rem;
            font-weight: 600;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: #f59e0b;
            margin-bottom: .75rem;
        }

        .form-title {
            font-family: 'Syne', sans-serif;
            font-size: 2rem;
            font-weight: 800;
            color: #0b0c10;
            line-height: 1.15;
            margin-bottom: .5rem;
        }

        .form-sub {
            font-size: .9rem;
            color: #9ca3af;
            margin-bottom: 2.25rem;
        }

        .field-label {
            display: block;
            font-size: .8rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: .45rem;
            letter-spacing: .02em;
        }

        .field-wrap {
            position: relative;
            margin-bottom: 1.25rem;
        }

        .field-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 1rem;
            pointer-events: none;
            transition: color .2s;
        }

        .field-input {
            width: 100%;
            padding: .85rem 1rem .85rem 2.6rem;
            border: 1.5px solid #e5e7eb;
            border-radius: 12px;
            font-family: 'DM Sans', sans-serif;
            font-size: .95rem;
            color: #111827;
            background: #f9fafb;
            transition: border-color .2s, background .2s, box-shadow .2s;
            outline: none;
        }

        .field-input:focus {
            border-color: #f59e0b;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(245,158,11,.1);
        }

        .field-input:focus + .field-icon,
        .field-wrap:focus-within .field-icon {
            color: #f59e0b;
        }

        .field-input.is-invalid {
            border-color: #ef4444;
            background: #fff5f5;
        }

        .error-msg {
            font-size: .78rem;
            color: #ef4444;
            margin-top: .35rem;
            display: flex;
            align-items: center;
            gap: .3rem;
        }

        .btn-login {
            width: 100%;
            padding: .95rem;
            background: linear-gradient(135deg, #1a1a2e 0%, #0f0f1a 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-family: 'DM Sans', sans-serif;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform .15s, box-shadow .15s, opacity .15s;
            margin-top: .5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            letter-spacing: .01em;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(15,15,26,.35);
        }

        .btn-login:active { transform: translateY(0); }

        .divider {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 1.75rem 0;
            color: #d1d5db;
            font-size: .8rem;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e5e7eb;
        }

        .badge-secure {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            font-size: .75rem;
            color: #6b7280;
            background: #f3f4f6;
            border-radius: 99px;
            padding: .35rem .9rem;
            margin-top: 2rem;
        }
        .badge-secure i { color: #10b981; font-size: .85rem; }

        /* Responsive */
        @media (max-width: 768px) {
            .login-visual { display: none; }
            .login-form-side { width: 100%; }
        }

        /* Animación de entrada */
        .form-inner { animation: slideUp .5s cubic-bezier(.22,1,.36,1) both; }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<!-- Panel visual izquierdo -->
<div class="login-visual">
    <div class="car-grid">
        @for($i = 0; $i < 9; $i++)
        <div class="car-grid-item"><i class="bi bi-car-front-fill"></i></div>
        @endfor
    </div>
    <div class="visual-brand">Auto<span>Premium</span></div>
    <p class="visual-tagline">La mejor selección de vehículos premium. Tu próximo auto te está esperando.</p>
</div>

<!-- Panel formulario derecho -->
<div class="login-form-side">
    <div class="form-inner">
        <p class="form-eyebrow"><i class="bi bi-shield-lock me-1"></i>Acceso seguro</p>
        <h1 class="form-title">Bienvenido de vuelta</h1>
        <p class="form-sub">Ingresá tus credenciales para continuar.</p>

        <form action="{{ route('login.post') }}" method="POST" novalidate>
            @csrf

            <!-- Email -->
            <div>
                <label class="field-label" for="email">Correo electrónico</label>
                <div class="field-wrap">
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="field-input @error('email') is-invalid @enderror"
                        value="{{ old('email') }}"
                        placeholder="correo@ejemplo.com"
                        autocomplete="email"
                        autofocus
                    >
                    <i class="bi bi-envelope field-icon"></i>
                </div>
                @error('email')
                <p class="error-msg"><i class="bi bi-exclamation-circle-fill"></i>{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label class="field-label" for="password">Contraseña</label>
                <div class="field-wrap">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="field-input @error('password') is-invalid @enderror"
                        placeholder="••••••••"
                        autocomplete="current-password"
                    >
                    <i class="bi bi-lock field-icon"></i>
                </div>
                @error('password')
                <p class="error-msg"><i class="bi bi-exclamation-circle-fill"></i>{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn-login">
                <i class="bi bi-box-arrow-in-right"></i> Ingresar
            </button>
        </form>

        <div class="divider">o</div>

        <div class="text-center">
            <span class="badge-secure">
                <i class="bi bi-shield-check-fill"></i>
                Conexión cifrada y protegida
            </span>
        </div>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>