<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('curp');
            $table->integer('modulo_atencion_id')->unsigned();
            $table->foreign('modulo_atencion_id')->references('id')->on('modulos_atencion');
            $table->timestamps();
            $table->integer('tramite_id')->unsigned();
            $table->foreign('tramite_id')->references('id')->on('tramites');
            $table->dateTime('horario');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('citas');
    }
}
