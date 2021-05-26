<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreContratosParcelas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cre_contratos_parcelas', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('num_parcela');
            $table->date('data_vencimento');
            $table->double('valor_parcela');
            $table->double('valor_pago_parcela');
            $table->double('valor_devedor_parcela');
            $table->double('valor_juros_parcela');
            $table->integer('dias_atraso');
            $table->string('situacao');
             $table->date('data_movimento');

            $table->integer('cre_id_contratos')->unsigned();
            $table->foreign('cre_id_contratos')->references('id')->on('cre_contratos');
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
        Schema::dropIfExists('cre_contratos_parcelas');
    }
}
