<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProPrevidenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pro_previdencias', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->string('documento');
            $table->string('n_registro');
            $table->string('aposentadoria');
            $table->string('autopatrocionio');
            $table->string('resgate');
            $table->string('beneficioproporiconal');
            $table->date('data_adesao');
            $table->date('data_desligamento');
            $table->string('situacao_participante');
            $table->string('tipo_participante');
            $table->string('forma_pagamento');
            $table->string('plano');
            $table->string('regime');
            $table->double('peculio_morte');
            $table->double('peculio_invalidez');
            $table->double('valor_proposta');
            $table->date('data_movimento');
            
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
        Schema::dropIfExists('pro_previdencias');
    }
}
