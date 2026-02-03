<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Mascota;
use Faker\Factory as Faker;
use Carbon\Carbon;

class TurnoSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $motivos = [
            'chequeo',
            'vacunacion',
            'piel',
            'digestivo',
            'oido_ojo',
            'dental',
            'urinario',
            'dolor_movilidad',
            'post_op',
            'otro',
        ];

        $mascotas = Mascota::pluck('id_mascota');

        $empleados = DB::table('usuario')->where('rol', 'empleado')->pluck('id_usuario');

        foreach (range(1, 20) as $i) {
            DB::table('turno')->insert([
                'id_mascota' => $faker->randomElement($mascotas),
                'id_veterinario' => $faker->randomElement($empleados),
                'fecha_hora' => $faker->dateTimeBetween('now', '+1 month'),
                'motivo' => $faker->randomElement($motivos),
                'estado' => $faker->randomElement(['pendiente', 'completado', 'cancelado']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        //  1 Turno como minimo para el veterinario id_2 (empleado)
        $veterinarioId = 2;

        $mascotasVeterinario = DB::table('veterinario_mascota')
            ->where('id_veterinario', $veterinarioId)
            ->pluck('id_mascota');

        foreach ($mascotasVeterinario as $idMascota) {
            $existe = DB::table('turno')
                ->where('id_mascota', $idMascota)
                ->where('id_veterinario', $veterinarioId)
                ->exists();

            if (!$existe) {
                DB::table('turno')->insert([
                    'id_mascota' => $idMascota,
                    'id_veterinario' => $veterinarioId,
                    'fecha_hora' => Carbon::now()->addDays(rand(1, 10))->setTime(rand(10, 17), 0),
                    'motivo' => 'otro', 
                    'estado' => 'pendiente',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
