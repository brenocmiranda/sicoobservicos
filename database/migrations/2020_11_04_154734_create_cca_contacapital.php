<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCcaContacapital extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cca_contacapital', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            
            $table->integer('num_capital')->unique();,
            $table->string('situacao_capital');
            $table->string('direito_voto');
            $table->string('direito_rateio');
            $table->date('data_matricula');
            $table->date('saida_matricula');
            $table->double('valor_integralizado');
            $table->date('data_movimento');
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
        Schema::dropIfExists('cca_contacapital');
    }
}
