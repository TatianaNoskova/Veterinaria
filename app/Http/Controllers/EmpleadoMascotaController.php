<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;  
use App\Models\Mascota; 
use App\Models\Turno; 
use App\Models\Diagnostico;
use Illuminate\Support\Facades\Auth;

class EmpleadoMascotaController extends Controller
{
   public function index()
{
    $clientes = Usuario::where('rol', 'cliente')->get();
    $empleado_id = auth()->id();

    
    $mascotasAsignadas = Mascota::whereHas('veterinarios', function ($query) use ($empleado_id) {
        $query->where('id_veterinario', $empleado_id)->where('activo', true);
    })->with('clientes')->get();

    
    $mascotasNoAsignadas = Mascota::whereDoesntHave('veterinarios', function ($query) use ($empleado_id) {
        $query->where('id_veterinario', $empleado_id);
    })->get();

    return view('empleado.mascota', compact('clientes', 'mascotasAsignadas', 'mascotasNoAsignadas'));
}


    public function create() {
        
        $clientes = Usuario::where('rol', 'cliente')->get();
        
        return view('empleado.mascotas.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'clientes_ids' => 'required|array|min:1',
            'clientes_ids.*' => 'exists:usuario,id_usuario,rol,cliente', 
            'nombre' => 'required|string|max:100', 
            'especie' => 'required|in:canino,felino',
            'sexo' => 'required|in:macho,hembra', 
            'raza' => 'nullable|string|max:100', 
            'edad' => 'required|integer|min:0',
        ]);

        $mascota = Mascota::create([
            'nombre' => $validated['nombre'],
            'especie' => $validated['especie'],
            'sexo' => $validated['sexo'],
            'raza' => $validated['raza'] ?? null,
            'edad' => $validated['edad'],
        ]);
        // mascota --> cliente
        $mascota->clientes()->attach($validated['clientes_ids']);
        // mascota --> veterinario
        $empleado_id = auth()->user()->id_usuario;
        if (!$mascota->veterinarios()->where('id_veterinario', $empleado_id)->exists()) {
            $mascota->veterinarios()->attach($empleado_id, [
                'fecha_asignacion' => now(),
                'activo' => true,
            ]);
        }

        return redirect()->route('empleado.mascotas.index')->with('success', 'Mascota registrada correctamente.');
    }

// mostrar mascotas ya registradas en el sistema/no asignadas al veterinario logueado
public function showMascotasRegistradas()
{
    
    $empleado_id = auth()->id();  


$mascotas = Mascota::whereDoesntHave('veterinarios', function ($query) use ($empleado_id) {
    $query->where('id_veterinario', $empleado_id);
})->get();


    
    return view('empleado.mascota', compact('mascotas'));
}

public function agregarMascota(Request $request)
{

    $mascota = Mascota::find($request->mascota_id);

    $empleado_id = auth()->user()->id_usuario;

    if ($mascota && !$mascota->veterinarios()->where('id_veterinario', $empleado_id)->exists()) {
        $mascota->veterinarios()->attach($empleado_id, [
            'fecha_asignacion' => now(),
            'activo' => true,
        ]);
    }

    return redirect()->route('empleado.mascotas.index')->with('success', 'Mascota agregada correctamente.');
}

public function edit($id)
{
    $mascota = Mascota::findOrFail($id);
    
    $clientes = Usuario::where('rol', 'cliente')->get();

    $primerDueno = $mascota->clientes->first(); 
    $segundoDueno = $mascota->clientes->count() > 1 ? $mascota->clientes->last() : null; 

    return view('empleado.mascota_edit', compact('mascota', 'clientes', 'primerDueno', 'segundoDueno'));
}




public function update(Request $request, $id)
{
    $request->validate([
        'nombre'  => 'required|string|max:255',
        'especie' => 'required|string|max:255',
        'raza'    => 'required|string|max:255',
        'edad'    => 'required|integer|min:0',
        'sexo'    => 'required|string|max:255',
    ]);

    $mascota = Mascota::findOrFail($id);

    $mascota->update($request->all());

    $nuevo_dueno_id = $request->input('dueno');
    
    $segundo_dueno_id = $request->input('dueno_secundario');

    $clientes_ids = [$nuevo_dueno_id];

    if ($segundo_dueno_id) {
        $clientes_ids[] = $segundo_dueno_id;
    }

    $mascota->clientes()->sync($clientes_ids);

    return redirect()->route('empleado.mascotas.index')
        ->with('success', '¡Mascota actualizada con éxito!');
}

public function destroy($id)
{

    $mascota = Mascota::findOrFail($id);

    $mascota->diagnosticos()->delete(); 
    $mascota->turnos()->delete();

     $mascota->veterinarios()->detach(); 

    $mascota->delete();

    return redirect()->route('empleado.mascotas.index')->with('success', 'Mascota eliminada con éxito');
}



public function historiaNueva($id)
{
    $mascota = Mascota::findOrFail($id);

    $dueños = $mascota->clientes;

    return view('empleado.historia_nueva', compact('mascota', 'dueños'));
}


public function storeDiagnostico(Request $request, $id)
{
    
    $validatedData = $request->validate([
        'fecha' => 'required|date',           
        'descripcion' => 'required|string',    
        'receta' => 'nullable|string', 
        'id_turno' => 'required|exists:turno,id_turno', 
    ]);

    
    $veterinario = auth()->user();

    
    $mascota = Mascota::findOrFail($id);

    
    $turno = Turno::where('id_turno', $validatedData['id_turno'])
                  ->where('id_veterinario', $veterinario->id_usuario) 
                  ->first();

    
    if (!$turno) {
        return redirect()->back()->with('error', 'Este turno no pertenece a su veterinario.');
    }

    
    $diagnostico = new Diagnostico();
    $diagnostico->id_mascota = $mascota->id_mascota;  
    $diagnostico->fecha = $validatedData['fecha'];    
    $diagnostico->descripcion = $validatedData['descripcion']; 
    $diagnostico->receta = $validatedData['receta']; 
    $diagnostico->id_turno = $turno->id_turno;  
    $diagnostico->save(); 

   
    return redirect()->route('empleado.mascotas.index')->with('success', 'Diagnóstico registrado con éxito');
}


public function historial($id)
{
    // Находим питомца по его ID и загружаем диагнозы с визитом и ветеринаром
    $mascota = Mascota::with(['diagnosticos.turno.veterinario'])->findOrFail($id);

    // Получаем всех владельцев питомца
    $dueños = $mascota->clientes;

    // Возвращаем представление и передаем питомца, его диагнозы и владельцев
    return view('empleado.mascota_historial', compact('mascota', 'dueños'));
}




















}