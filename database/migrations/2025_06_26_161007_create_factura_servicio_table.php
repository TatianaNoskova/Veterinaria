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
    Schema::create('factura_servicio', function (Blueprint $table) {
        $table->unsignedBigInteger('id_factura');
        $table->unsignedBigInteger('id_servicio');
        $table->tinyInteger('cantidad')->nullable()->default(1);
        $table->decimal('precio', 10, 2);
        $table->decimal('subtotal', 10, 2)->nullable();
        $table->timestamps();

        $table->primary(['id_factura', 'id_servicio']);

        $table->foreign('id_factura')
              ->references('id_factura')
              ->on('factura')
              ->onDelete('cascade')
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
        Schema::dropIfExists('factura_servicio');
    }
};
