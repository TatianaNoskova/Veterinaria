<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class FacturaSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $turnos = DB::table('turno')->pluck('id_turno');
        $servicios = DB::table('servicio')->get();

        foreach ($turnos as $turnoId) {
          
            $fecha = $faker->dateTimeBetween('-2 months', 'now');
            $estado = $faker->randomElement(['pendiente', 'pagado']);
            $fecha_pagado = $estado === 'pagado' ? Carbon::parse($fecha)->addDays(rand(0, 5)) : null;

          
            $facturaId = DB::table('factura')->insertGetId([
                'id_turno' => $turnoId,
                'fecha' => $fecha,
                'estado' => $estado,
                'fecha_pagado' => $fecha_pagado,
                'total' => 0, 
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            
            $serviciosSeleccionados = $servicios->random(rand(1, 3));

            $total = 0;

            foreach ($serviciosSeleccionados as $servicio) {
                $cantidad = rand(1, 2);
                $subtotal = $servicio->precio * $cantidad;

                DB::table('factura_servicio')->insert([
                    'id_factura' => $facturaId,
                    'id_servicio' => $servicio->id_servicio,
                    'cantidad' => $cantidad,
                    'precio' => $servicio->precio,
                    'subtotal' => $subtotal,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $total += $subtotal;
            }

            DB::table('factura')
                ->where('id_factura', $facturaId)
                ->update(['total' => $total]);
        }

        $this->command->info('Facturas y servicios asociados se han generado correctamente.');
    }
}
