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
    Schema::create('usuario_mascota', function (Blueprint $table) {
        $table->unsignedBigInteger('id_usuario');
        $table->unsignedBigInteger('id_mascota');

        $table->timestamps();

        $table->primary(['id_usuario', 'id_mascota']); 

        $table->foreign('id_usuario')
              ->references('id_usuario')
              ->on('usuario')
              ->onDelete('cascade')
              ->onUpdate('cascade');

        $table->foreign('id_mascota')
              ->references('id_mascota')
              ->on('mascota')
              ->onDelete('cascade')
              ->onUpdate('cascade');
    });
}



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuario_mascota');
    }
};
