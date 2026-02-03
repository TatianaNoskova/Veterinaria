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
        Schema::create('factura', function (Blueprint $table) {
            $table->id('id_factura');

            $table->unsignedBigInteger('id_turno')->nullable();
            $table->foreign('id_turno')
                ->references('id_turno')
                ->on('turno')
                ->onDelete('set null'); 

            $table->date('fecha');
            $table->decimal('total', 10, 2);
            $table->enum('estado', ['pendiente', 'pagado'])->default('pendiente');
            $table->date('fecha_pagado')->nullable();

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
        Schema::dropIfExists('factura');
    }
};
