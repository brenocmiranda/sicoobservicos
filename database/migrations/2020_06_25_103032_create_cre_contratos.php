<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreContratos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cre_contratos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('num_contrato')->unique();
            $table->string('produto');
            $table->string('codigo_produto');
            $table->string('sigla_produto');
            $table->string('situacao');
            $table->date('data_operacao');
            $table->date('data_vencimento');
            $table->date('data_quitacao')->nullable();
            $table->double('valor_contrato');
            $table->string('finalidade');
            $table->string('cod_linha');
            $table->string('linha');
            $table->string('renegociacao');
            $table->integer('cli_id_associado')->unsigned();
            $table->foreign('cli_id_associado')->references('id')->on('cli_associados');
            $table->integer('cre_id_arquivo')->unsigned();
            $table->foreign('cre_id_arquivo')->references('id')->on('cre_arquivos');
            $table->double('taxa_operacao');
            $table->double('taxa_mora');
            $table->double('taxa_multa');

            // Informações complementares
            $table->string('nivel_risco')->nullable();
            $table->double('valor_devido')->nullable();
            $table->integer('qtd_parcelas')->nullable();
            $table->integer('qtd_parcelas_pagas')->nullable();
            $table->string('renegociacao_contrato')->nullable();
            $table->text('observacoes')->nullable();
            // Informações complementares

            $table->date('data_movimento');
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
        Schema::dropIfExists('cre_contratos');
    }
}
