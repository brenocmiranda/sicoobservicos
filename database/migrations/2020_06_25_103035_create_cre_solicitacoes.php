<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreSolicitacoes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cre_solicitacoes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->text('observacoes')->nullable();
            $table->integer('usr_id_usuario')->unsigned();
            $table->foreign('usr_id_usuario')->references('id')->on('usr_usuarios');
            $table->integer('cre_id_arquivos')->unsigned();
            $table->foreign('cre_id_arquivos')->references('id')->on('cre_arquivos');
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
        Schema::dropIfExists('cre_solicitacoes');
    }
}
