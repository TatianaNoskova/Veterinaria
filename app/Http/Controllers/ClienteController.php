<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Mascota;

class ClienteController extends Controller
{
    public function index()
{
    $cliente = auth()->user();
    $mascotas = $cliente->mascotas;
        foreach ($mascotas as $mascota) {
    $otrosDuenos = $mascota->clientes->where('id_usuario', '!=', $cliente->id_usuario);

    $mascota->otros_duenos = $otrosDuenos->map(function ($dueno) {
        return $dueno->nombre . ' ' . $dueno->apellido;
    })->join(', ');
        }



    return view('user.perfil', compact('cliente', 'mascotas'));
}

public function actualizarPerfil(Request $request)
{
    $cliente = auth()->user();

    $validated = $request->validate([
        'nombre' => 'required|string|max:255',
        'apellido' => 'required|string|max:255',
        'dni' => 'required|string|max:20',
        'telefono' => 'nullable|string|max:30',
        'correo_electronico' => 'required|email|max:255',
        'direccion' => 'nullable|string|max:250',
        'password' => 'nullable|string|min:6|confirmed',
    ]);

    if (!empty($validated['password'])) {
        $validated['password'] = Hash::make($validated['password']);
    } else {
        unset($validated['password']);
    }

    $cliente->update($validated);

    return redirect()->route('user.perfil.index')->with('success', 'Perfil actualizado.');
}


    public function eliminarCuenta(Request $request)
{
    try {
        $cliente = auth()->user();

        
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

    
        $cliente->delete();

    
        return redirect('/login')->with('success', 'Cuenta eliminada');
    } catch (\Exception $e) {
        \Log::error('Error: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Ocurrió un error al eliminar la cuenta.');
    }
}


   
}
