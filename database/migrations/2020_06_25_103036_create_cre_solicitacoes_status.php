<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreSolicitacoesStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cre_solicitacoes_status', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->enum('status', ['aberto', 'entregue', 'devolvido']);
            $table->integer('usr_id_usuario_alteracao')->unsigned();
            $table->foreign('usr_id_usuario_alteracao')->references('id')->on('usr_usuarios');
            $table->integer('cre_id_solicitacoes')->unsigned();
            $table->foreign('cre_id_solicitacoes')->references('id')->on('cre_solicitacoes');
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
        Schema::dropIfExists('cre_solicitacoes_status');
    }
}
