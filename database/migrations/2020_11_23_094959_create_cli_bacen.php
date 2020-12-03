<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCliBacen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cli_bacen', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->date('data_movimento');
            $table->string('modalidade');
            $table->string('submodalidade');
            $table->double('saldo_prejuizo');
            $table->double('saldo_responsabilidade');
            $table->double('saldo_credito_liberar');
            $table->integer('cli_id_associado')->unsigned();
            $table->foreign('cli_id_associado')->references('id')->on('cli_associados');
            $table->double('saldo_avencer');
            $table->double('saldo_avencer_30');
            $table->double('saldo_avencer_3160');
            $table->double('saldo_avencer_6190');
            $table->double('saldo_avencer_91180');
            $table->double('saldo_avencer_181360');
            $table->double('saldo_avencer_361720');
            $table->double('saldo_avencer_7211080');
            $table->double('saldo_avencer_10811440');
            $table->double('saldo_avencer_14411800');
            $table->double('saldo_avencer_18015400');
            $table->double('saldo_avencer_5400');
            $table->double('saldo_avencer_indeterminado');
            $table->double('saldo_vencido');
            $table->double('saldo_vencido_1530');
            $table->double('saldo_vencido_3160');
            $table->double('saldo_vencido_6190');
            $table->double('saldo_vencido_91120');
            $table->double('saldo_vencido_121150');
            $table->double('saldo_vencido_151180');
            $table->double('saldo_vencido_181240');
            $table->double('saldo_vencido_241300');
            $table->double('saldo_vencido_301360');
            $table->double('saldo_vencido_361540');
            $table->double('saldo_vencido_540');

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
        Schema::dropIfExists('cli_bacen');
    }
}
