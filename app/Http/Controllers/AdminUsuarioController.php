<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;  

class AdminUsuarioController extends Controller
{
    public function index() {
        
        $usuarios = Usuario::where('rol', 'cliente')->get();

        
        return view('admin.usuario', compact('usuarios'));
    }

    

public function store(Request $request)
{
    $validated = $request->validate([
        'nombre' => 'required|string|max:255',
        'apellido' => 'required|string|max:255',
        'dni' => 'required|string|unique:usuario,dni',
        'correo_electronico' => 'required|email|unique:usuario,correo_electronico',
        'telefono' => 'nullable|string|max:20',
        'direccion' => 'nullable|string|max:255',
        'password' => 'required|string|min:6|confirmed', 
    ]);

    Usuario::create([
        'nombre' => $validated['nombre'],
        'apellido' => $validated['apellido'],
        'dni' => $validated['dni'],
        'correo_electronico' => $validated['correo_electronico'],
        'telefono' => $validated['telefono'],
        'direccion' => $validated['direccion'],
        'rol' => 'cliente',
        'password' => bcrypt($validated['password']),  
    ]);

    return redirect()->route('admin.usuarios.index')->with('success', 'Cliente registrado correctamente.');
}



    public function edit($id) {
        $usuario = Usuario::findOrFail($id);
        return view('admin.usuario_edit', compact('usuario'));
    }

    public function update(Request $request, $id) {
    $validated = $request->validate([
        'nombre' => 'required|string|max:255',
        'apellido' => 'required|string|max:255',
        'dni' => 'required|string|unique:usuario,dni,' . $id . ',id_usuario',
        'correo_electronico' => 'required|email|unique:usuario,correo_electronico,' . $id . ',id_usuario',
        'telefono' => 'nullable|string|max:20',
        'direccion' => 'nullable|string|max:255',
        'rol' => 'required|in:cliente,empleado,admin',
    ]);

    $usuario = \App\Models\Usuario::where('id_usuario', $id)->firstOrFail();
    
    if ($request->filled('password')) {
        $validated['password'] = bcrypt($request->input('password'));
    } else {
        unset($validated['password']); 
    }
    $usuario->update($validated);

    return redirect()->route('admin.usuarios.index')->with('success', 'Los datos están modidicados');
}

    public function destroy($id) {


    $usuario = Usuario::where('id_usuario', $id)->firstOrFail();

    if ($usuario->rol !== 'cliente') {
        return redirect()->route('admin.usuarios.index')->with('error', 'No puedes eliminar este usuario.');
    }

    $usuario->delete();

    return redirect()->route('admin.usuarios.index')->with('success', 'Cliente eliminado correctamente.');
}

    
}
