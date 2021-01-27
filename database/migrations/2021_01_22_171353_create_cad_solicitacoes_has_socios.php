<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCadSolicitacoesHasSocios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cad_solicitacoes_has_socios', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('cad_id_solicitacoes')->unsigned()->nullable();
            $table->foreign('cad_id_solicitacoes')->references('id')->on('cad_solicitacoes');
            $table->integer('cli_id_associado')->unsigned()->nullable();
            $table->foreign('cli_id_associado')->references('id')->on('cli_associados');
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
        Schema::dropIfExists('cad_solicitacoes_has_socios');
    }
}
