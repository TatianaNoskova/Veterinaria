<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('servicio')->insert([
            [
                'nombre' => 'Consulta general',
                'tipo' => 'servicio_medico',
                'precio' => 45000.00,
                'descripcion' => 'Consulta médica general para el diagnóstico y tratamiento de enfermedades comunes.',
            ],
            [
                'nombre' => 'Vacuna antirrábica',
                'tipo' => 'servicio_medico',
                'precio' => 55000.00,
                'descripcion' => 'Vacunación para prevenir la rabia en los animales.',
            ],
            [
                'nombre' => 'Limpieza dental',
                'tipo' => 'servicio_extra',
                'precio' => 35000.00,
                'descripcion' => 'Limpieza dental para eliminar el sarro y mantener la salud oral.',
            ],
            [
                'nombre' => 'Corte de uñas',
                'tipo' => 'servicio_extra',
                'precio' => 25000.00,
                'descripcion' => 'Corte de uñas para mantenerlas en una longitud adecuada y evitar molestias.',
            ],
            [
                'nombre' => 'Desparacitación interna',
                'tipo' => 'servicio_medico',
                'precio' => 30000.00,
                'descripcion' => 'Tratamiento para eliminar parásitos internos en los animales.',
            ],
            [
                'nombre' => 'Baño y peluquería',
                'tipo' => 'servicio_extra',
                'precio' => 20000.00,
                'descripcion' => 'Servicio de baño y peluquería para mantener el pelaje de la mascota limpio y saludable.',
            ],
        ]);
    }
}

