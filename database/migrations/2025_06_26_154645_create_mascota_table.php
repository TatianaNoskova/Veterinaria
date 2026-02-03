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
    Schema::create('mascota', function (Blueprint $table) {
        $table->id('id_mascota');
        
        $table->string('nombre', 100);
        $table->enum('especie', ['canino', 'felino']);
        $table->string('raza', 100)->nullable();
        $table->integer('edad');
        $table->enum('sexo', ['macho', 'hembra']);
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
        Schema::dropIfExists('mascota');
    }
};
