<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('usuario', function (Blueprint $table) {
        $table->id('id_usuario');
        $table->string('nombre', 50);
        $table->string('apellido', 50);
        $table->string('password', 100);
        $table->string('dni', 20);
        $table->string('telefono', 20)->nullable();
        $table->string('correo_electronico', 100)->unique();
        $table->string('direccion', 250)->nullable();
        $table->string('matricula', 50)->nullable();
        $table->string('especialidad', 50)->nullable();
        $table->enum('rol', ['admin', 'empleado', 'cliente']);
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuario');
    }
};
