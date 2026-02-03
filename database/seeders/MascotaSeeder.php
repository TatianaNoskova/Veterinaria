<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mascota;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;

class MascotaSeeder extends Seeder
{
    public function run()
    {
        $clientes = Usuario::where('rol', 'cliente')->get();
        $empleados = Usuario::where('rol', 'empleado')->get();

        // 10 animales
        $mascotas = Mascota::factory(20)->create();

        foreach ($mascotas as $mascota) {
            // amimal --> dueño (1 o 2)
            $mascota->clientes()->attach(
                $clientes->random(rand(1, 2))->pluck('id_usuario')->toArray()
            );

            // animal --> veterinario (1 o 2)
            $mascota->veterinarios()->attach(
                $empleados->random(rand(1, 2))->pluck('id_usuario')->toArray(),
                ['fecha_asignacion' => now(), 'activo' => true]
            );
        }
    }
}

