<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCadNovosHasStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cad_novos_has_status', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->enum('status', ['devolvido', 'aberto', 'andamento', 'finalizado', 'cancelado']);
            $table->text('descricao')->nullable();

            $table->integer('usr_id_usuarios')->unsigned();
            $table->foreign('usr_id_usuarios')->references('id')->on('usr_usuarios');
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
        Schema::dropIfExists('cad_novos_has_status');
    }
}
