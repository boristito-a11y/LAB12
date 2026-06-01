<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RolMiddleware
{
    public function handle(Request $request, Closure $next, string $rol)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (auth()->user()->rol !== $rol) {
            abort(403, 'Acceso denegado. No tienes permiso para esta sección.');
        }

        return $next($request);
    }
}