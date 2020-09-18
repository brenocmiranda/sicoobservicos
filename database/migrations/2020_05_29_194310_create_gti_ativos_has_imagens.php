<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGtiAtivosHasImagens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gti_ativos_has_imagens', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->integer('id_ativo')->unsigned();
            $table->foreign('id_ativo')->references('id')->on('gti_ativos');
            $table->integer('id_imagem')->unsigned();
            $table->foreign('id_imagem')->references('id')->on('imagens');

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
        Schema::dropIfExists('gti_ativos_has_imagens');
    }
}
