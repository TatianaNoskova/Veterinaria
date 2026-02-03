<?php

namespace App\Http\Controllers;

use App\Models\Mascota;
use App\Models\Usuario;
use App\Models\Turno;
use Illuminate\Http\Request;
use Carbon\Carbon;


class UserTurnoController extends Controller
{
    public function index()
    {
        $usuario = auth()->user();
        $mascotas = auth()->user()->mascotas;
        $veterinarios = Usuario::where('rol', 'empleado')->get();  
        $especialidades = Usuario::select('especialidad')->distinct()->pluck('especialidad');
        $turnosDisponibles = collect();  
        $turnosReservados = Turno::whereIn('id_mascota', $usuario->mascotas->pluck('id_mascota'))
        ->where('fecha_hora', '>=', now())
        ->with(['veterinario', 'mascota'])
        ->orderBy('fecha_hora')
        ->get();


        return view('user.turno', compact(
            'usuario',
            'mascotas',
            'veterinarios',
            'especialidades',
            'turnosDisponibles',
            'turnosReservados'
        ));
    }

public function buscar(Request $request)
{
    $usuario = auth()->user();
    $mascotas = $usuario->mascotas;
    $veterinarios = Usuario::where('rol', 'empleado')->get();
    $especialidades = $veterinarios->pluck('especialidad')->unique()->filter()->values();
    $turnosDisponibles = collect();

    $filtrosUsados = collect([
    $request->filled('veterinario'),
    $request->filled('especialidad'),
    $request->filled('fecha_turno')
    ])->filter()->count();

if ($filtrosUsados > 1) {
    $mascotas = $usuario->mascotas;
    $veterinarios = Usuario::where('rol', 'empleado')->get();
    $especialidades = $veterinarios->pluck('especialidad')->unique()->filter()->values();
    $turnosDisponibles = collect();

    return redirect()->route('user.turnos.index')
    ->withErrors(['Por favor, seleccione solo un filtro a la vez.'])
    ->withFragment('errores');
}

    if ($request->filled('veterinario')) {
        $veterinarioId = $request->input('veterinario');

        $inicio = Carbon::now();
        $fin    = Carbon::now()->addDays(7);

        $slots = collect();
        $fecha = Carbon::parse($request->fecha_turno)->startOfDay();
        $isToday = $fecha->isToday();

    for ($date = $inicio->copy(); $date <= $fin; $date->addDay()) {
    if ($date->dayOfWeek === Carbon::SUNDAY) continue; 

    
    if ($date->isWeekday()) {
        $horaInicio = 10;
        $horaFin = 18;
       
    }
    elseif ($date->dayOfWeek === Carbon::SATURDAY) {
        $horaInicio = 10;
        $horaFin = 14;    
    }

    for ($hora = $horaInicio; $hora < $horaFin; $hora++) {
        foreach ([0, 30] as $minuto) {
            $slot = $date->copy()->setTime($hora, $minuto);
            if ($isToday && $slot->lt(Carbon::now())) continue; // ⛔️ Skip past slots
            $slots->push($slot);
        }
    }
}

            $bloqueados = \DB::table('bloqueos_de_slots')
                ->where('id_veterinario', $veterinarioId)
                ->pluck('fecha_hora')
                ->map(function ($dt) {
                
                    return Carbon::parse($dt)->format('Y-m-d H:i');
            });

            $ocupados = \DB::table('turno')
                ->where('id_veterinario', $veterinarioId)
                ->pluck('fecha_hora')
                ->map(function ($dt) {
                
                return Carbon::parse($dt)->format('Y-m-d H:i');
            });
        
            $slotsDisponibles = $slots->filter(function ($slot) use ($bloqueados, $ocupados) {
            $formateado = $slot->format('Y-m-d H:i');
                
                return !$bloqueados->contains($formateado) && !$ocupados->contains($formateado);
            });

            $turnosDisponibles = $slotsDisponibles->map(function ($fechaHora) use ($veterinarioId) {
                
                return (object)[
                'fecha_hora' => $fechaHora,
                'veterinario' => Usuario::find($veterinarioId),
                ];
            });
    }

    if ($request->filled('especialidad')) {
        $especialidad = $request->input('especialidad');
        $veterinariosIds = Usuario::where('rol', 'empleado')
            ->where('especialidad', $especialidad)
            ->pluck('id_usuario');

    $inicio = Carbon::now();
    $fin = Carbon::now()->addDays(6);

    $slots = collect();
    $fecha = Carbon::parse($request->fecha_turno)->startOfDay();
    $isToday = $fecha->isToday();

    for ($date = $inicio->copy(); $date <= $fin; $date->addDay()) {
    if ($date->dayOfWeek === Carbon::SUNDAY) continue; 

    if ($date->isWeekday()) {
        $horaInicio = 10;
        $horaFin = 18;
       
    }
    elseif ($date->dayOfWeek === Carbon::SATURDAY) {
        $horaInicio = 10;
        $horaFin = 14;   
    }

    for ($hora = $horaInicio; $hora < $horaFin; $hora++) {
        foreach ([0, 30] as $minuto) {
            $slot = $date->copy()->setTime($hora, $minuto);
            if ($isToday && $slot->lt(Carbon::now())) continue;
            $slots->push($slot);
        }
    }
}
    foreach ($veterinariosIds as $vetId) {
        $bloqueados = \DB::table('bloqueos_de_slots')
            ->where('id_veterinario', $vetId)
            ->pluck('fecha_hora')
            ->map(function ($dt) {
                return Carbon::parse($dt)->format('Y-m-d H:i');
            });

        $ocupados = \DB::table('turno')
            ->where('id_veterinario', $vetId)
            ->pluck('fecha_hora')
            ->map(function ($dt) {
                return Carbon::parse($dt)->format('Y-m-d H:i');
            });

        $slotsDisponibles = $slots->filter(function ($slot) use ($bloqueados, $ocupados) {
            $formateado = $slot->format('Y-m-d H:i');
            return !$bloqueados->contains($formateado) && !$ocupados->contains($formateado);
        });

        foreach ($slotsDisponibles as $fechaHora) {
            $turnosDisponibles->push((object)[
                'fecha_hora' => $fechaHora,
                'veterinario' => Usuario::find($vetId),
            ]);
        }
    }

}

elseif ($request->filled('fecha_turno')) {
    
    $fecha = Carbon::parse($request->fecha_turno, config('app.timezone'))->startOfDay();
    $hoy = Carbon::now(config('app.timezone')); 
    

    $esHoy = $fecha->isToday();

    if ($fecha->isSunday()) {
        return redirect()->route('user.turnos.index')
            ->withErrors(['La clínica no atiende los domingos. Por favor, elige otra fecha.'])
            ->withFragment('errores');
    }

    if ($fecha->between(Carbon::now()->startOfDay(), Carbon::now()->addDays(7)->endOfDay())) {
        
    $veterinariosIds = Usuario::where('rol', 'empleado')->pluck('id_usuario');
    $veterinariosMap = Usuario::whereIn('id_usuario', $veterinariosIds)->get()->keyBy('id_usuario');
    $slots = collect();

    foreach ($veterinariosIds as $idVet) {
    $horaInicio = 10;
    $horaFin = $fecha->isSaturday() ? 14 : 18;

    for ($hora = $horaInicio; $hora < $horaFin; $hora++) {
        foreach ([0, 30] as $minutos) {
            $slot = $fecha->copy()->setTime($hora, $minutos);

            if ($esHoy && $slot->lte($hoy)) {
                
                continue;
            }

            
            $slots->push([$idVet, $slot]);
        }
    }
}



      

    $bloqueados = \DB::table('bloqueos_de_slots')
    ->whereIn('id_veterinario', $veterinariosIds)
    ->whereDate('fecha_hora', $fecha)
    ->get()
    ->mapWithKeys(fn($item) => [
        $item->id_veterinario . '|' . Carbon::parse($item->fecha_hora)->format('Y-m-d H:i') => true
    ]);


    $ocupados = \DB::table('turno')
    ->whereIn('id_veterinario', $veterinariosIds)
    ->whereDate('fecha_hora', $fecha)
    ->get()
    ->mapWithKeys(fn($item) => [
        $item->id_veterinario . '|' . Carbon::parse($item->fecha_hora)->format('Y-m-d H:i') => true
    ]);

    $turnosDisponibles = collect();
    foreach ($slots as [$idVet, $fechaHora]) {
    $formateado = $idVet . '|' . $fechaHora->format('Y-m-d H:i');

    if (
        !$bloqueados->has($formateado) &&
        !$ocupados->has($formateado)
    ) {
        $turnosDisponibles->push((object)[
            'fecha_hora' => $fechaHora,
            'veterinario' => $veterinariosMap[$idVet],
        ]);
    }
}

}


    

}

    $turnosReservados = Turno::whereIn('id_mascota', $usuario->mascotas->pluck('id_mascota'))
        ->where('fecha_hora', '>=', now())
        ->with(['mascota', 'veterinario'])
        ->orderBy('fecha_hora')
        ->get();

    return view('user.turno', compact(
    'usuario',
    'mascotas',
    'veterinarios',
    'especialidades',
    'turnosDisponibles',
    'turnosReservados'
));

}

public function reservar(Request $request, $fechaHora)
{

    $request->validate([
        'id_mascota' => 'required|exists:mascota,id_mascota',
        'id_veterinario' => 'required|exists:usuario,id_usuario',
        'motivo' => 'required|string|max:255',
    ]);

    $fecha = Carbon::createFromFormat('Y-m-d_H-i', $fechaHora);

    $yaReservado = Turno::where('id_veterinario', $request->id_veterinario)
        ->where('fecha_hora', $fecha)
        ->exists();

    if ($yaReservado) {
        return redirect()->back()->withErrors(['Este turno ya ha sido reservado.']);
    }

    $bloqueado = \DB::table('bloqueos_de_slots')
        ->where('id_veterinario', $request->id_veterinario)
        ->where('fecha_hora', $fecha)
        ->exists();

    if ($bloqueado) {
        return redirect()->back()->withErrors(['Este horario no está disponible.']);
    }

    Turno::create([
        'id_mascota' => $request->id_mascota,
        'id_veterinario' => $request->id_veterinario,
        'fecha_hora' => $fecha,
        'motivo' => $request->motivo,
        'estado' => 'pendiente',
    ]);

    return redirect()->route('user.turnos.index')
        ->with('success', 'Turno reservado con éxito.')
        ->withFragment('user-turnos-registrados');
}

public function cancelar($id_turno)
{
    $usuario = auth()->user();

    $turno = Turno::where('id_turno', $id_turno)
        ->whereIn('id_mascota', $usuario->mascotas->pluck('id_mascota'))
        ->first();

    if (!$turno) {
        return redirect()->route('user.turnos.index')
            ->withErrors(['No se encontró el turno o no tienes permiso para cancelarlo.']);
    }

    $turno->delete();

    return redirect()->route('user.turnos.index')
        ->with('success', 'Turno cancelado correctamente.');
}


}

