<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGtiAtivosHasUsuarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gti_ativos_has_usuarios', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('dataDevolucao')->nullable();
            $table->string('dataRecebimento');

            $table->integer('gti_id_ativos')->unsigned();
            $table->foreign('gti_id_ativos')->references('id')->on('gti_ativos');
            $table->integer('usr_id_usuarios')->unsigned();
            $table->foreign('usr_id_usuarios')->references('id')->on('usr_usuarios');

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
        Schema::dropIfExists('gti_ativos_has_usuarios');
    }
}
