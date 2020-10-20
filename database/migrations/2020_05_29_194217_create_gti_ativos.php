<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGtiAtivos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gti_ativos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('n_patrimonio');
            $table->string('serialNumber');
            $table->string('nome');
            $table->string('marca');
            $table->string('modelo');
            $table->text('descricao')->nullable();

            $table->integer('id_setor')->unsigned();
            $table->foreign('id_setor')->references('id')->on('usr_setores');
            $table->integer('id_unidade')->unsigned();
            $table->foreign('id_unidade')->references('id')->on('usr_unidades');
            $table->integer('id_imagem')->unsigned()->nullable();
            $table->foreign('id_imagem')->references('id')->on('imagens');

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
        Schema::dropIfExists('gti_ativos');
    }
}
