<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Diagnostico;
use App\Models\Turno;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class DiagnosticoSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        
        $diagnosticos = [
            'chequeo' => [
                'descripcion' => 'Chequeo general: mascota en buen estado de salud. Peso y temperatura normales.',
                'receta' => 'Vitaminas y control en 6 meses.',
            ],
            'vacunacion' => [
                'descripcion' => 'Vacunación aplicada correctamente. Sin reacciones adversas.',
                'receta' => 'Revacunación en un año.',
            ],
            'piel' => [
                'descripcion' => 'Dermatitis leve con irritación en la zona lumbar.',
                'receta' => 'Crema tópica antialérgica por 7 días.',
            ],
            'digestivo' => [
                'descripcion' => 'Diarrea aguda por cambio de alimentación.',
                'receta' => 'Dieta blanda + probióticos durante 3 días.',
            ],
            'oido_ojo' => [
                'descripcion' => 'Otitis externa con secreción leve.',
                'receta' => 'Gotas óticas antibióticas por 5 días.',
            ],
            'dental' => [
                'descripcion' => 'Gingivitis moderada, acumulación de sarro.',
                'receta' => 'Limpieza dental programada + antibiótico oral.',
            ],
            'urinario' => [
                'descripcion' => 'Cistitis bacteriana confirmada por análisis de orina.',
                'receta' => 'Antibióticos por 7 días y aumento de hidratación.',
            ],
            'dolor_movilidad' => [
                'descripcion' => 'Signos de artrosis en caderas, movilidad reducida.',
                'receta' => 'Condroprotectores y analgésico cada 12h.',
            ],
            'post_op' => [
                'descripcion' => 'Control post-operatorio sin complicaciones.',
                'receta' => 'Continuar con analgésicos y reposo.',
            ],
            'otro' => [
                'descripcion' => 'Consulta por comportamiento ansioso.',
                'receta' => 'Juguetes interactivos y control ambiental.',
            ],
        ];

        $turnos = Turno::all();

        foreach ($turnos as $turno) {
            $motivo = $turno->motivo;

            
            $contenido = $diagnosticos[$motivo] ?? [
                'descripcion' => 'Consulta general sin diagnóstico específico.',
                'receta' => 'Observación y seguimiento.',
            ];

            Diagnostico::create([
                'id_mascota' => $turno->id_mascota,
                'id_turno' => $turno->id_turno,
                'fecha' => $turno->fecha_hora,
                'descripcion' => $contenido['descripcion'],
                'receta' => $contenido['receta'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('Diagnósticos seeded!');
    }
}
