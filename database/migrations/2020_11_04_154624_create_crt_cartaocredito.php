<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrtCartaocredito extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crt_cartaocredito', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('num_contrato')->unique();
            $table->string('situacao');
            $table->integer('cod_cliente')->nullable();
            $table->string('funcao_cartao');
            $table->string('produto_cartao')->nullable();
            $table->string('bandeira_cartao')->nullable();
            $table->string('fatura')->nullable();
            $table->integer('venc_fatura')->nullable();
            $table->date('data_abertura');
            $table->date('data_limite');
            $table->date('data_fechamento');
            $table->double('valor_atribuido');
            $table->double('valor_disponivel')->nullable();
            $table->double('valor_utilizado')->nullable();
            $table->integer('cli_id_associado')->unsigned();
            $table->foreign('cli_id_associado')->references('id')->on('cli_associados');
            $table->integer('cre_id_arquivo')->unsigned();
            $table->foreign('cre_id_arquivo')->references('id')->on('cre_arquivos');

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
        Schema::dropIfExists('crt_cartaocredito');
    }
}
