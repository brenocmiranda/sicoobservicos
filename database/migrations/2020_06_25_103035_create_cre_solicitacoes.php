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
            $table->text('observacoes');
            $table->enum('status', ['aberto', 'entregue', 'devolvido']);
            $table->integer('usr_id_usuario')->unsigned();
            $table->integer('cre_id_contratos')->unsigned();
            $table->foreign('usr_id_usuario')->references('id')->on('usr_usuarios');
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
        Schema::dropIfExists('cre_solicitacoes');
    }
}
