<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Usuario;

class UsuariosSeeder extends Seeder
{
    public function run()
    {
        $usuarios = [
            [
                'nombre' => 'Admin',
                'apellido' => 'Admin',
                'password' => Hash::make('password'),
                'dni' => '10000000',
                'telefono' => '+54 11 1111111',
                'correo_electronico' => 'admin@example.com',
                'direccion' => 'Calle Admin, 1, CABA',
                'rol' => 'admin'
            ],
            [
                'nombre' => 'Empleado',
                'apellido' => 'Empleado',
                'password' => Hash::make('password'),
                'dni' => '20000000',
                'telefono' => '+54 11 2222222',
                'correo_electronico' => 'empleado@example.com',
                'direccion' => 'Calle Empleado, 2, CABA',
                'rol' => 'empleado',
                'especialidad' => 'Medicina General'
            ],
            [
                'nombre' => 'Cliente',
                'apellido' => 'Cliente',
                'password' => Hash::make('password'),
                'dni' => '30000000',
                'telefono' => '+54 11 3333333',
                'correo_electronico' => 'cliente@example.com',
                'direccion' => 'Calle Cliente, 3, CABA',
                'rol' => 'cliente'
            ],
        ];

        foreach ($usuarios as $usuario) {
            DB::table('usuario')->updateOrInsert(
                ['correo_electronico' => $usuario['correo_electronico']],
                $usuario
            );
        }

        // 🔧 Список доступных especialidades solo para empleados
        $especialidades = [
            'Medicina General',
            'Cardiología',
            'Dermatología',
            'Cirugía',
            'Estética Animal',
        ];

        // ➕ Empleados con especialidades aleatorias
        Usuario::factory()->count(5)->create([
            'rol' => 'empleado',
        ])->each(function ($usuario) use ($especialidades) {
            $usuario->especialidad = collect($especialidades)->random();
            $usuario->save();
        });

        // ➕ Clientes normales
        Usuario::factory()->count(10)->create([
            'rol' => 'cliente',
        ]);
    }
}

