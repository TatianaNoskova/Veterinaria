<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MascotaFactory extends Factory
{
    public function definition(): array
    {
        $especie = $this->faker->randomElement(['canino', 'felino']);

        $razasCaninas = ['Labrador Retriever', 'Bulldog', 'Golden Retriever', 'Beagle', 'Poodle'];
        $razasFelinas = ['Persa', 'Siames', 'Bengal', 'Siberiano', 'Maine Coon'];

        $raza = $especie === 'canino'
            ? $this->faker->randomElement($razasCaninas)
            : $this->faker->randomElement($razasFelinas);

        return [
            'nombre' => $this->faker->firstName,
            'especie' => $especie,
            'raza' => $raza,
            'edad' => $this->faker->numberBetween(1, 15),
            'sexo' => $this->faker->randomElement(['Macho', 'Hembra']),
        ];
    }
}


