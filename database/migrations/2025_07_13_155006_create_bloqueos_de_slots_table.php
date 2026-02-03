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
    Schema::create('bloqueos_de_slots', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('id_veterinario');
        $table->dateTime('fecha_hora');
        $table->timestamps();

        $table->foreign('id_veterinario')->references('id_usuario')->on('usuario')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bloqueos_de_slots');
    }
};
