<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UsuarioFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->firstName,
            'apellido' => $this->faker->lastName,
            'password' => Hash::make('password'),
            'dni' => $this->faker->unique()->numerify('########'),
            'telefono' => $this->faker->phoneNumber,
            'correo_electronico' => $this->faker->unique()->safeEmail,
            'direccion' => $this->faker->address,
            'rol' => 'cliente', 
        ];
    }
}
