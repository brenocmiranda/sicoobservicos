<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProConsorciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pro_consorcios', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('n_contrato');
            $table->string('grupo');
            $table->string('cota');
            $table->string('versao');
            $table->string('situacao');
            $table->double('taxa_administracao');
            $table->integer('prazo');
            $table->integer('parcelas_pagas');
            $table->text('segmento');
            $table->string('tipo_contemplacao');
            $table->integer('prazo_pagamento');
            $table->string('forma_pagamento');
            $table->string('bem_referencia');
            $table->date('data_adesao');
            $table->date('data_cancelamento');
            $table->double('valor_contratado');
            $table->date('data_movimento');            

            $table->integer('cli_id_associado')->unsigned();
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
        Schema::dropIfExists('pro_consorcios');
    }
}
