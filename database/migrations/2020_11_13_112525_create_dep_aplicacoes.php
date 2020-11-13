<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepAplicacoes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dep_aplicacoes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->bigInteger('num_conta');
            $table->string('modalidade');
            $table->string('tipo');
            $table->double('valor_correcao');
            $table->double('valor_inicial');
            $table->double('valor_saldo');
            $table->date('data_movimento');
            $table->integer('cco_id_contacorrente')->unsigned();
            $table->foreign('cco_id_contacorrente')->references('id')->on('cco_contacorrente');
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
        Schema::dropIfExists('dep_aplicacoes');
    }
}
