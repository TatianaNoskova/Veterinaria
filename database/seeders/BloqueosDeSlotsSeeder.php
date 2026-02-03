<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Usuario;

class BloqueosDeSlotsSeeder extends Seeder
{
    public function run()
    {
        
        $veterinarios = Usuario::where('rol', 'empleado')->get();

        foreach ($veterinarios as $vet) {
    $bloqueos = 0;

    while ($bloqueos < 3) {
        $fecha = Carbon::now()->addDays(rand(2, 7))->startOfDay();
        $diaSemana = $fecha->dayOfWeekIso; 

        if ($diaSemana == 7) {
            continue;
        }

        if ($diaSemana >= 1 && $diaSemana <= 5) {
            
            $hora = rand(10, 17);
        } elseif ($diaSemana == 6) {
            
            $hora = rand(10, 13);
        }

        $fecha->setTime($hora, 0, 0);

        DB::table('bloqueos_de_slots')->insert([
            'id_veterinario' => $vet->id_usuario,
            'fecha_hora' => $fecha,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $bloqueos++;
    }
}

}
}

