<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
    UsuariosSeeder::class,
    MascotaSeeder::class,
    TurnoSeeder::class, 
   
    DiagnosticoSeeder::class,
    ServicioSeeder::class,
    FacturaSeeder::class,
    BloqueosDeSlotsSeeder:: class,

]);

    }
}
