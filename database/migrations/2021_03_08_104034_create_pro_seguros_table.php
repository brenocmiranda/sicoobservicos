<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProSegurosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pro_seguros', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('documento');
            $table->text('nome_associado');
            $table->string('n_proposta');
            $table->string('n_apolice');
            $table->string('corretora');
            $table->string('seguradora');
            $table->string('ramo');
            $table->string('familia');
            $table->string('produto');
            $table->string('tipo_proposta');
            $table->double('premio_bruto');
            $table->double('premio_liquido');
            $table->double('comissao');
            $table->date('data_vigencia');
            $table->date('data_encerramento');
            $table->string('cpf_atendente');
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
        Schema::dropIfExists('pro_seguros');
    }
}
