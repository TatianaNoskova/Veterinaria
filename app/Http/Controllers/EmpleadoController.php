<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    // Главная панель ветеринара
    public function index()
    {

        $usuario = auth()->user();
        return view('empleado.dashboard', compact('usuario'));
    }

}  






