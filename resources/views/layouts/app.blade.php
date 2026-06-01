<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoPremium — Agencia de Vehículos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { background: #f0f2f5; min-height: 100vh; }

        /* ── NAVBAR ── */
        .navbar-main {
            background: linear-gradient(135deg, #0f0f1a 0%, #1a1a2e 60%, #16213e 100%);
            padding: .75rem 0;
            box-shadow: 0 4px 20px rgba(0,0,0,.3);
            position: sticky; top: 0; z-index: 1000;
        }
        .navbar-brand-text {
            font-size: 1.3rem; font-weight: 800; color: white !important;
            letter-spacing: -.5px; text-decoration: none;
        }
        .navbar-brand-text span { color: #f59e0b; }
        .nav-link-custom {
            color: rgba(255,255,255,.75) !important;
            font-weight: 500; padding: .5rem 1rem !important;
            border-radius: 8px; transition: all .2s;
            text-decoration: none; display: inline-flex; align-items: center; gap: .4rem;
        }
        .nav-link-custom:hover { background: rgba(255,255,255,.1); color: white !important; }
        .nav-link-custom.active { background: rgba(245,158,11,.15); color: #f59e0b !important; }

        /* Badge carrito */
        .cart-badge {
            background: #ef4444; color: white; font-size: .65rem;
            font-weight: 700; padding: .15rem .45rem;
            border-radius: 99px; margin-left: .25rem;
        }

        /* Botón usuario */
        .btn-user {
            background: rgba(255,255,255,.08);
            border: 1px solid rgba(255,255,255,.15);
            color: white; border-radius: 10px;
            padding: .4rem 1rem; font-size: .9rem;
            font-weight: 500; transition: all .2s;
        }
        .btn-user:hover { background: rgba(255,255,255,.15); color: white; }
        .btn-logout {
            background: rgba(239,68,68,.15);
            border: 1px solid rgba(239,68,68,.3);
            color: #fca5a5; border-radius: 10px;
            padding: .4rem 1rem; font-size: .9rem;
            font-weight: 500; cursor: pointer; transition: all .2s;
        }
        .btn-logout:hover { background: rgba(239,68,68,.3); color: white; }

        /* ── CONTENIDO ── */
        .main-content { padding: 2rem 0 3rem; }

        /* Alertas */
        .alert-modern {
            border: none; border-radius: 12px; font-weight: 500;
            padding: 1rem 1.25rem;
            box-shadow: 0 2px 10px rgba(0,0,0,.08);
        }
        .alert-success.alert-modern { background: #ecfdf5; color: #065f46; }
        .alert-danger.alert-modern  { background: #fef2f2; color: #991b1b; }
    </style>
</head>
<body>

@auth
<nav class="navbar-main">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between w-100">
            <a class="navbar-brand-text" href="#">
                <i class="bi bi-car-front-fill me-1"></i>Auto<span>Premium</span>
            </a>

            <div class="d-flex align-items-center gap-2">
                @if(auth()->user()->esAdmin())
                    <a class="nav-link-custom" href="{{ route('admin.marcas.index') }}">
                        <i class="bi bi-tags"></i> Marcas
                    </a>
                    <a class="nav-link-custom" href="{{ route('admin.vehiculos.index') }}">
                        <i class="bi bi-car-front"></i> Vehículos
                    </a>
                @else
                    <a class="nav-link-custom" href="{{ route('usuario.vehiculos.index') }}">
                        <i class="bi bi-grid-3x3-gap"></i> Catálogo
                    </a>
                    <a class="nav-link-custom" href="{{ route('usuario.carrito.index') }}">
                        <i class="bi bi-cart3"></i> Carrito
                        @php $cant = collect(session('carrito_' . auth()->id(), []))->sum('cantidad'); @endphp
                        @if($cant > 0)<span class="cart-badge">{{ $cant }}</span>@endif
                    </a>
                @endif

                <a class="btn-user ms-2" href="{{ route('perfil.edit') }}">
                    <i class="bi bi-person-circle me-1"></i>{{ auth()->user()->name }}
                </a>

                <form action="{{ route('logout') }}" method="POST" class="d-inline m-0">
                    @csrf
                    <button class="btn-logout"><i class="bi bi-box-arrow-right me-1"></i>Salir</button>
                </form>
            </div>
        </div>
    </div>
</nav>
@endauth

<div class="main-content">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-modern alert-dismissible fade show mb-3">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-modern alert-dismissible fade show mb-3">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>