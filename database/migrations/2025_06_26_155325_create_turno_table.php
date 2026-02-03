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
        Schema::create('turno', function (Blueprint $table) {
            $table->id('id_turno');

            $table->unsignedBigInteger('id_mascota')->nullable();
            $table->unsignedBigInteger('id_veterinario')->nullable();

            $table->dateTime('fecha_hora');
            $table->enum('motivo', [
                        'chequeo',
                        'vacunacion',
                        'piel',
                        'digestivo',
                        'oido_ojo',
                        'dental',
                        'urinario',
                        'dolor_movilidad',
                        'post_op',
                        'otro'
                        ])->nullable();

            $table->enum('estado', ['pendiente', 'completado', 'cancelado'])->default('pendiente');;

            $table->timestamps();

            $table->foreign('id_mascota')
                ->references('id_mascota')
                ->on('mascota')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('id_veterinario')
                ->references('id_usuario')
                ->on('usuario')
                ->onDelete('set null')
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
        Schema::dropIfExists('turno');
    }
};
