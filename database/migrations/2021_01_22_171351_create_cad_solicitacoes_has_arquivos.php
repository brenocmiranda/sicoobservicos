<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCadSolicitacoesHasArquivos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cad_solicitacoes_has_arquivos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('nome');

            $table->integer('id_arquivo')->unsigned();
            $table->foreign('id_arquivo')->references('id')->on('sys_arquivos');
            $table->integer('cad_id_solicitacoes')->unsigned();
            $table->foreign('cad_id_solicitacoes')->references('id')->on('cad_solicitacoes');
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
        Schema::dropIfExists('cad_solicitacoes_has_arquivos');
    }
}
