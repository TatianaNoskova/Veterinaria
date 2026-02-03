<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Usuario;

class Impersonate
{
    public function handle($request, Closure $next)
    {
        if (Session::has('impersonate')) {
            Auth::onceUsingId(Session::get('impersonate'));
        }

        return $next($request);
    }
}

