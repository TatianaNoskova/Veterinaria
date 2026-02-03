<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Usuario;
use App\Models\Turno;
use App\Models\BloqueoSlot;
use Carbon\Carbon;

class EmpleadoHorarioController extends Controller
{
  
   public function index(Request $request)
{
    $veterinario = auth()->user();

    if ($request->filled('schedule-date')) {
        $request->validate([
            'schedule-date' => ['required', 'date', function ($attribute, $value, $fail) {
                $fecha = Carbon::parse($value);
                $hoy = Carbon::today();
                $max = $hoy->copy()->addDays(7);

                if ($fecha->lt($hoy) || $fecha->gt($max)) {
                    $fail('La fecha debe estar entre hoy y dentro de 7 días.');
                }

                if ($fecha->isSunday()) {
                    $fail('¡Es tu día libre, che! Descansá y disfrutá de la vida 😄');
                }
            }],
        ]);
    }

    $fecha = Carbon::parse($request->input('schedule-date', Carbon::today()->toDateString()));


    if ($fecha->isSunday()) {
        return redirect()->route('empleado.horario')
            ->withErrors(['La clínica no atiende los domingos.'])
            ->withInput();
    }

    $horaInicio = 10;
    $horaFin = $fecha->isSaturday() ? 14 : 18;

    $slots = collect();
    for ($hora = $horaInicio; $hora < $horaFin; $hora++) {
        foreach ([0, 30] as $minuto) {
            $horaCompleta = $fecha->copy()->setTime($hora, $minuto);
            $slots->push($horaCompleta);
        }
    }

    if ($fecha->isToday()) {
        $ahora = Carbon::now();
        $slots = $slots->filter(fn($slot) => $slot->greaterThanOrEqualTo($ahora));
    }

    $ocupados = Turno::where('id_veterinario', $veterinario->id_usuario)
        ->whereDate('fecha_hora', $fecha)
        ->pluck('fecha_hora')
        ->map(fn($h) => Carbon::parse($h)->format('H:i'));

    $bloqueados = \DB::table('bloqueos_de_slots')
        ->where('id_veterinario', $veterinario->id_usuario)
        ->whereDate('fecha_hora', $fecha)
        ->pluck('fecha_hora')
        ->map(fn($h) => Carbon::parse($h)->format('H:i'));

    $resultado = $slots->map(function ($horaSlot) use ($ocupados, $bloqueados) {
        $horaTexto = $horaSlot->format('H:i');

        if ($ocupados->contains($horaTexto)) {
            return [
                'hora' => $horaTexto,
                'estado_texto' => 'RESERVADO',
                'estado_css' => 'reservado',
            ];
        }

        if ($bloqueados->contains($horaTexto)) {
            return [
                'hora' => $horaTexto,
                'estado_texto' => 'BLOQUEADO',
                'estado_css' => 'bloqueado',
            ];
        }

        return [
            'hora' => $horaTexto,
            'estado_texto' => 'Disponible',
            'estado_css' => 'disponible',
        ];
    });

    return view('empleado.horario', [
    'veterinario' => $veterinario,
    'slots' => $resultado,
    'fecha' => $fecha->format('d/m/Y'),
    'minDate' => Carbon::today()->format('Y-m-d'),
    'maxDate' => Carbon::today()->addDays(7)->format('Y-m-d'),
    'selectedDate' => $request->input('schedule-date', Carbon::today()->format('Y-m-d')),
]);
}
public function bloquearSlot(Request $request)
{
    $request->validate([
        'fecha' => 'required|date_format:d/m/Y',
        'hora' => 'required|date_format:H:i',
    ]);

    $veterinario = auth()->user();

    $fechaHoraStr = $request->input('fecha') . ' ' . $request->input('hora');
    $fechaHora = Carbon::createFromFormat('d/m/Y H:i', $fechaHoraStr);

    $existe = BloqueoSlot::where('id_veterinario', $veterinario->id_usuario)
        ->where('fecha_hora', $fechaHora)
        ->exists();

    if ($existe) {
        return back()->withErrors(['El slot ya está bloqueado.']);
    }

    BloqueoSlot::create([
        'id_veterinario' => $veterinario->id_usuario,
        'fecha_hora' => $fechaHora,
    ]);

    return back()->with('success', 'Slot bloqueado correctamente.');
}
}



