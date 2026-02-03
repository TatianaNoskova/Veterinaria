<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsEmpleado
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->rol === 'empleado') {
            return $next($request);
        }

        abort(403, 'Acceso denegado: solo para empleados.');
    }
}

