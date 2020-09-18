<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGtiChamadosHasImagens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gti_chamados_has_imagens', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->integer('gti_id_chamados')->unsigned();
            $table->foreign('gti_id_chamados')->references('id')->on('gti_chamados');
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
        Schema::dropIfExists('gti_chamados_has_imagens');
    }
}
