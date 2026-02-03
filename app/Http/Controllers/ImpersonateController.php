<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;


class ImpersonateController extends Controller
{

    public function show()
    {
        $usuarios = Usuario::whereIn('rol', ['cliente', 'empleado'])->get();

        return view('admin.ingresar_como', compact('usuarios'));
    }

       public function start($id)
    {
        $adminId = Auth::id(); 

        session()->put('impersonate_by', $adminId);

        Auth::loginUsingId($id);

        $rol = Auth::user()->rol;

        return match ($rol) {
            'cliente'  => redirect()->route('user.dashboard'),
            'empleado' => redirect()->route('empleado.dashboard'),
            'admin'    => redirect()->route('admin.dashboard'),
            default    => abort(403, 'Rol desconocido'),
        };
    }

    

    public function stop()
    {
        Session::forget('impersonate');

        return redirect()->route('admin.dashboard')->with('success', 'Has dejado de impersonar.');
    }
}

