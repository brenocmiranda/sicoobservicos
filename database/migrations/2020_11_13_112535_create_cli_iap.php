<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCliIap extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cli_iap', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->integer('indicador_conta_limite');
            $table->integer('indicador_cobranca');
            $table->integer('indicador_consorcio');
            $table->integer('indicador_consorcio_auto');
            $table->integer('indicador_consorcio_imovel');
            $table->integer('indicador_consorcio_servicos');
            $table->integer('indicador_consorcio_moto');
            $table->integer('indicador_conta_capital');
            $table->integer('indicador_credito_rural');
            $table->integer('indicador_cartao_credito');
            $table->integer('indicador_sipag');
            $table->integer('indicador_previdencia');
            $table->integer('indicador_pacotes_tarifa');
            $table->integer('indicador_emprestimo');
            $table->integer('indicador_financiamento');
            $table->integer('indicador_poupanca');
            $table->integer('indicador_rdc');
            $table->integer('indicador_lca');
            $table->integer('indicador_seguro_auto');
            $table->integer('indicador_seguro_massificados');
            $table->integer('indicador_seguro_rural');
            $table->integer('indicador_seguro_vida');
            $table->integer('indicador_prestamista');
            $table->integer('indicador_titulo_descontado');
            $table->integer('produtos_pf');
            $table->integer('produtos_pj');
            $table->string('data_movimento');
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
        Schema::dropIfExists('cli_iap');
    }
}
