<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCliConsolidado extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cli_consolidado', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->string('nivel_risco');
            $table->string('nivel_risco_crl');
            $table->date('data_crl');
            $table->text('porte_cliente');
            $table->integer('indicador_rural');
            $table->text('categoria_rural');
            $table->string('escolaridade');
            $table->string('estado_civil');
            $table->double('valor_imovel');
            $table->double('valor_movel');
            $table->integer('cli_id_associado')->unsigned();
            $table->foreign('cli_id_associado')->references('id')->on('cli_associados');

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
        Schema::dropIfExists('cli_consolidado');
    }
}
