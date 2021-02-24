<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCadNovosHasArquivos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cad_novos_has_arquivos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('nome');

            $table->integer('id_arquivo')->unsigned();
            $table->foreign('id_arquivo')->references('id')->on('sys_arquivos');
            $table->integer('cad_id_novos')->unsigned();
            $table->foreign('cad_id_novos')->references('id')->on('cad_novos');
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
        Schema::dropIfExists('cad_novos_has_arquivos');
    }
}
