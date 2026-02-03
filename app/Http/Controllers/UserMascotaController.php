<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mascota;
use App\Models\Usuario;

class UserMascotaController extends Controller
{
    
   public function create()
{
    $cliente = auth()->user(); 
    $clientes = Usuario::where('rol', 'cliente')->get();

    return view('user.agregar_mascota', compact('clientes'));
}

    
 public function store(Request $request)
{
    $request->validate([
        'nombre' => 'required|string|max:100',
        'especie' => 'required|in:canino,felino',
        'raza' => 'nullable|string|max:100',
        'edad' => 'required|integer|min:0',
        'sexo' => 'required|in:macho,hembra',
        'dueno_secundario' => 'nullable|exists:usuario,id_usuario',
    ]);

    $user = auth()->user();

    $yaExiste = Mascota::where('nombre', $request->nombre)
        ->where('especie', $request->especie)
        ->where('raza', $request->raza)
        ->where('edad', $request->edad)
        ->where('sexo', $request->sexo)
        ->whereHas('clientes', function ($query) use ($user) {
            $query->where('usuario.id_usuario', $user->id_usuario);
        })
        ->exists();

    if ($yaExiste) {
        return redirect()->back()
            ->withErrors(['Esta mascota ya ha sido registrada.'])
            ->withInput();
    }

    $mascota = Mascota::create([
        'nombre' => $request->nombre,
        'especie' => $request->especie,
        'raza' => $request->raza,
        'edad' => $request->edad,
        'sexo' => $request->sexo,
    ]);

    $mascota->clientes()->attach($user->id_usuario);

    if ($request->filled('dueno_secundario')) {
        $segundoDueno = Usuario::find($request->dueno_secundario);
        if ($segundoDueno && $segundoDueno->rol === 'cliente') {
            $mascota->clientes()->attach($segundoDueno->id_usuario);
        }
    }

    return redirect()->route('user.perfil.index')->with('success', 'Mascota agregada correctamente.');
}


public function edit($id)
{
    $mascota = Mascota::findOrFail($id);
    
    $clientes = Usuario::where('rol', 'cliente')->get();

    $primerDueno = $mascota->clientes->first(); 
    $segundoDueno = $mascota->clientes->count() > 1 ? $mascota->clientes->last() : null; 

    $cliente = auth()->user(); 

    return view('user.mascota_edit', compact('mascota', 'clientes', 'primerDueno', 'segundoDueno', 'cliente')); 
}



public function update(Request $request, $id) 
{
    
    $mascota = Mascota::findOrFail($id);

    
    $request->validate([
        'nombre'   => 'required|string|max:255',
        'especie'  => 'required|string|in:Perro,Gato',
        'raza'     => 'required|string|max:255',
        'edad'     => 'required|integer|min:0',
        'sexo'     => 'required|string|in:Hembra,Macho',
    ]);

    
    $mascota->update([
        'nombre'   => $request->nombre,
        'especie'  => $request->especie == 'Perro' ? 'canino' : 'felino',
        'raza'     => $request->raza,
        'edad'     => $request->edad,
        'sexo'     => $request->sexo == 'Hembra' ? 'hembra' : 'macho',
    ]);

   
    $cliente = auth()->user(); 

       if ($request->filled('dueno_secundario')) {
        $segundoDuenoId = $request->dueno_secundario;

        $segundoDueno = Usuario::findOrFail($segundoDuenoId);

        $mascota->clientes()->sync([$cliente->id_usuario, $segundoDueno->id_usuario]);

    } else {
        
        $mascota->clientes()->sync([$cliente->id_usuario]);  
    }

   
    return redirect()->route('user.perfil.index')
        ->with('success', '¡Datos de la mascota actualizados correctamente!');
}

public function destroy($id)
{
    $mascota = Mascota::findOrFail($id);

    $cliente = auth()->user();

    $mascota->clientes()->detach($cliente->id_usuario);

    return redirect()->route('user.perfil.index')
        ->with('success', '¡La mascota ha sido eliminada de tu lista!');
    }

    public function list()
    {
        $mascotas = auth()->user()->mascotas;  
        return view('user.mascotas', compact('mascotas'));
    }


   public function showHistorial($id)
{
    $mascota = Mascota::with('diagnosticos.turno.veterinario')->findOrFail($id);
    $duenos = $mascota->clientes;

    return view('user.historial', compact('mascota', 'duenos'));
}

    
}














