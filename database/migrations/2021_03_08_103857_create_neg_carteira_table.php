<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNegCarteiraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('neg_carteira', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->double('especial_atual')->nullable();
            $table->double('cartao_atual')->nullable();
            $table->double('emp_atual')->nullable();
            $table->double('fin_atual')->nullable();
            $table->double('svida_atual')->nullable();
            $table->double('sgeral_atual')->nullable();
            $table->double('consorcio_atual')->nullable();
            $table->double('previdencia_atual')->nullable();

            $table->double('especial_sugerido')->nullable();
            $table->double('cartao_sugerido')->nullable();
            $table->double('emp_sugerido')->nullable();
            $table->double('fin_sugerido')->nullable();
            $table->double('svida_sugerido')->nullable();
            $table->double('sgeral_sugerido')->nullable();
            $table->double('consorcio_sugerido')->nullable();
            $table->double('previdencia_sugerido')->nullable();

            $table->double('especial_contratado')->nullable();
            $table->double('cartao_contratado')->nullable();
            $table->double('emp_contratado')->nullable();
            $table->double('fin_contratado')->nullable();
            $table->double('svida_contratado')->nullable();
            $table->double('sgeral_contratado')->nullable();
            $table->double('consorcio_contratado')->nullable();
            $table->double('previdencia_contratado')->nullable();

            $table->string('bc_data');
            $table->double('bc_consignados')->nullable();
            $table->double('bc_creditopessoal')->nullable();
            $table->double('bc_chequeespecial')->nullable();
            $table->double('bc_cartao')->nullable();
            $table->double('bc_financiamento')->nullable();
            $table->string('bc_dividavencida');

            $table->string('se_data');
            $table->string('se_restricao');
            $table->text('se_restricao_data')->nullable();
            $table->text('se_restricao_tipo')->nullable();
            $table->text('se_restricao_valor')->nullable();
            $table->string('se_endereco')->nullable();
            $table->string('se_telefone')->nullable();

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
        Schema::dropIfExists('neg_carteira');
    }
}
