<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = auth()->user();

        if (!$user) {
            abort(403, 'No autenticado.');
        }

        // ✅ Админ может всё
        if ($user->rol === 'admin') {
            return $next($request);
        }

        // ✅ Остальные — только если их роль разрешена
        if (!in_array($user->rol, $roles)) {
            abort(403, 'Acción no autorizada.');
        }

        return $next($request);
    }
}


