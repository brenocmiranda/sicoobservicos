<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCliAtividades extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cli_atividades', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->string('tipo');
            $table->text('descricao');
            $table->string('contato');
            $table->integer('usr_id_usuario')->unsigned();
            $table->foreign('usr_id_usuario')->references('id')->on('usr_usuarios');
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
        Schema::dropIfExists('cli_atividades');
    }
}
