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
            $table->string('n_patrimonio')->nullable();
            $table->string('serialNumber');
            $table->string('serviceTag')->nullable();
            $table->string('modelo');
            $table->text('descricao')->nullable();

            $table->integer('id_marca')->unsigned();
            $table->foreign('id_marca')->references('id')->on('gti_ativos_has_marcas');
            $table->integer('id_equipamento')->unsigned();
            $table->foreign('id_equipamento')->references('id')->on('gti_ativos_has_equipamentos');
            $table->integer('id_setor')->unsigned();
            $table->foreign('id_setor')->references('id')->on('usr_setores');
            $table->integer('id_unidade')->unsigned();
            $table->foreign('id_unidade')->references('id')->on('usr_unidades');
            $table->integer('id_imagem')->unsigned()->nullable();
            $table->foreign('id_imagem')->references('id')->on('sys_imagens');

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
