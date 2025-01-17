<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGtiChamadosHasArquivos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gti_chamados_has_arquivos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->integer('gti_id_chamados')->unsigned();
            $table->foreign('gti_id_chamados')->references('id')->on('gti_chamados');
            $table->integer('id_arquivo')->unsigned();
            $table->foreign('id_arquivo')->references('id')->on('sys_arquivos');

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
        Schema::dropIfExists('gti_chamados_has_arquivos');
    }
}
