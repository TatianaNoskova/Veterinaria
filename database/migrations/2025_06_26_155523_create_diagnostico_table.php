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
        Schema::create('diagnostico', function (Blueprint $table) {
            $table->id('id_diagnostico');
            $table->unsignedBigInteger('id_mascota');
            $table->unsignedBigInteger('id_turno');
            $table->date('fecha');
            $table->text('descripcion');
            $table->string('receta', 200)->nullable();
            $table->timestamps();

            
            $table->foreign('id_mascota')
                ->references('id_mascota')
                ->on('mascota')
                ->onDelete('cascade');  


             $table->foreign('id_turno')
                ->references('id_turno')
                ->on('turno')
                ->onDelete('cascade');     
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('diagnostico');
    }
};
