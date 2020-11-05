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
            $table->string('situacao_contrato');
            $table->date('data_operacao');
            $table->date('data_vencimento');
            $table->double('valor_contrato');
            $table->boolean('renegociacao')->nullable();
            $table->string('renegociacao_contrato')->nullable();
            $table->text('observacoes')->nullable();
            $table->integer('cli_id_associado')->unsigned();
            $table->foreign('cli_id_associado')->references('id')->on('cli_associados');
            $table->integer('cre_id_arquivo')->unsigned();
            $table->foreign('cre_id_arquivo')->references('id')->on('cre_arquivos');
            // Informações complementares
            $table->string('nivel_risco')->nullable();
            $table->double('taxa_operacao')->nullable();
            $table->double('taxa_mora')->nullable();
            $table->double('taxa_multa')->nullable();
            $table->double('valor_devido')->nullable();
            $table->integer('qtd_parcelas')->nullable();
            $table->integer('qtd_parcelas_pagas')->nullable();
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
