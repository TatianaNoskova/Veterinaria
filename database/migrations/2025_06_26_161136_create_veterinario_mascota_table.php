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
    Schema::create('veterinario_mascota', function (Blueprint $table) {
        $table->unsignedBigInteger('id_veterinario');
        $table->unsignedBigInteger('id_mascota');
        $table->date('fecha_asignacion');
        $table->boolean('activo')->default(true);
        $table->timestamps();

        $table->primary(['id_veterinario', 'id_mascota']);

        $table->foreign('id_veterinario')
              ->references('id_usuario')
              ->on('usuario')
              ->onDelete('no action')
              ->onUpdate('no action');

        $table->foreign('id_mascota')
              ->references('id_mascota')
              ->on('mascota')
              ->onDelete('no action')
              ->onUpdate('no action');
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('veterinario_mascota');
    }
};
