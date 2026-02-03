<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Mascota;
use App\Models\Turno;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EmpleadoTurnoController extends Controller
{


public function create(Request $request)
{
    $clientes = Usuario::where('rol', 'cliente')->get();
    $cliente = null;
    $mascotas = collect();

    if ($request->has('cliente')) {
        $cliente = Usuario::find($request->input('cliente'));
        if ($cliente) {
            $mascotas = $cliente->mascotas;
        }
    }

    $fechaInput = $request->input('fecha'); 
    $horaInput = $request->input('hora');   
    $fechaCarbon = null;
    $fechaHoraFormateada = null;

    $formatos = ['d-m-Y', 'd/m/Y'];

    foreach ($formatos as $formato) {
        try {
            $fechaCarbon = Carbon::createFromFormat("$formato H:i", "$fechaInput $horaInput");
            $fechaHoraFormateada = $fechaCarbon->format('Y-m-d H:i:s');
            break; 
        } catch (\Exception $e) {
            
        }
    }

    \Log::info("DEBUG: fecha = $fechaInput | hora = $horaInput | fecha_hora = $fechaHoraFormateada");

    return view('empleado.turno_agregar', [
        'clientes' => $clientes,
        'cliente' => $cliente,
        'mascotas' => $mascotas,
        'fecha' => $fechaInput,
        'hora' => $horaInput,
        'fecha_hora' => $fechaHoraFormateada,
    ]);
}

public function store(Request $request)
{

    $request->validate([
        'fecha_hora' => 'required|date_format:Y-m-d H:i:s',
        'mascota_id' => 'required|exists:mascota,id_mascota',
        'motivo' => 'required|string|max:255',
    ]);

    try {
        $fechaHora = Carbon::createFromFormat('Y-m-d H:i:s', $request->input('fecha_hora'));
    } catch (\Exception $e) {
        return back()->withErrors(['fecha_hora' => 'La fecha y hora no tienen el formato correcto.'])->withInput();
    }

    $veterinario = auth()->user();

    Turno::create([
        'id_mascota' => $request->mascota_id,
        'id_veterinario' => $veterinario->id_usuario,
        'fecha_hora' => $fechaHora,
        'motivo' => $request->motivo,
        'estado' => 'pendiente',
    ]);

    
    return redirect()->route('empleado.horario.index')->with('success', 'Turno asignado correctamente');
}






}
