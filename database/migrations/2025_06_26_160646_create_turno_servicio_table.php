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
    Schema::create('turno_servicio', function (Blueprint $table) {
        $table->unsignedBigInteger('id_turno');
        $table->unsignedBigInteger('id_servicio');

        $table->tinyInteger('cantidad')->nullable();
        $table->decimal('precio', 10, 2)->nullable();

        $table->timestamps();

        $table->primary(['id_turno', 'id_servicio']);

        $table->foreign('id_turno')
              ->references('id_turno')
              ->on('turno')
              ->onDelete('no action')
              ->onUpdate('no action');

        $table->foreign('id_servicio')
              ->references('id_servicio')
              ->on('servicio')
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
        Schema::dropIfExists('turno_servicio');
    }
};
