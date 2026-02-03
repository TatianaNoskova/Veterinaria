<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;

class AdminEmpleadoController extends Controller
{
    public function index() {
        
        $empleados = Usuario::where('rol', 'empleado')->get();

        
        return view('admin.empleado', compact('empleados'));
    }

    public function create() {
        return view('admin.empleado_create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'dni' => 'required|string|unique:usuario,dni',
            'correo_electronico' => 'required|email|unique:usuario,correo_electronico',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'matricula' => 'nullable|string|max:50',
            'especialidad' => 'nullable|string|max:50',
            'password' => 'required|string|min:6|',
            
            
        ]);

        Usuario::create([
            'nombre' => $validated['nombre'],
            'apellido' => $validated['apellido'],
            'dni' => $validated['dni'],
            'correo_electronico' => $validated['correo_electronico'],
            'telefono' => $validated['telefono'] ?? null,
            'direccion' => $validated['direccion'] ?? null,
            'matricula' => $validated['matricula'] ?? null,
            'especialidad' => $validated['especialidad'] ?? null,
            'rol' => 'empleado',
            'password' => bcrypt($validated['password']),
        ]);

        return redirect()->route('admin.empleados.index')->with('success', 'Empleado registrado correctamente.');
    }

    public function edit($id) {
        $empleado = Usuario::findOrFail($id);
        return view('admin.empleado_edit', compact('empleado'));
    }

public function update(Request $request, $id) {
    $validated = $request->validate([
        'nombre' => 'required|string|max:255',
        'apellido' => 'required|string|max:255',
        'dni' => 'required|string|unique:usuario,dni,' . $id . ',id_usuario',
        'correo_electronico' => 'required|email|unique:usuario,correo_electronico,' . $id . ',id_usuario',
        'telefono' => 'nullable|string|max:20',
        'direccion' => 'nullable|string|max:255',
        'matricula' => 'nullable|string|max:50',
        'especialidad' => 'nullable|string|max:50',
        'rol' => 'required|in:cliente,empleado,admin',
    ]);

    $empleado = Usuario::where('id_usuario', $id)->firstOrFail();

    if ($request->filled('password')) {
        $validated['password'] = bcrypt($request->input('password'));
    } else {
        unset($validated['password']);
    }

    $empleado->update($validated);

    return redirect()->route('admin.empleados.index')->with('success', 'Empleado actualizado correctamente.');
}



    public function destroy($id) {
        $empleado = Usuario::where('id_usuario', $id)->firstOrFail();

        if ($empleado->rol !== 'empleado') {
            return redirect()->route('admin.empleados.index')->with('error', 'No puedes eliminar este usuario.');
        }

        $empleado->delete();

        return redirect()->route('admin.empleados.index')->with('success', 'Empleado eliminado correctamente.');
    }
}
