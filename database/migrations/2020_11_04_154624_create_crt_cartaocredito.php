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
            $table->integer('num_cartao')->unique();
            $table->string('situacao_cartao');
            $table->integer('cod_cliente');
            $table->string('funcao_cartao');
            $table->string('produto_cartao');
            $table->string('bandeira_cartao');
            $table->string('fatura');
            $table->integer('venc_fatura');
            $table->date('data_abertura');
            $table->double('valor_atribuido');
            $table->double('valor_disponivel');
            $table->double('valor_utilizado');
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
