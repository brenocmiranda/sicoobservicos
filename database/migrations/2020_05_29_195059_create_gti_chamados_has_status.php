<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGtiChamadosHasStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gti_chamados_has_status', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->text('descricao')->nullable();

            $table->integer('gti_id_chamados')->unsigned();
            $table->foreign('gti_id_chamados')->references('id')->on('gti_chamados');
            $table->integer('gti_id_status')->unsigned();
            $table->foreign('gti_id_status')->references('id')->on('gti_status');
            $table->integer('usr_id_usuarios')->unsigned()->nullable();
            $table->foreign('usr_id_usuarios')->references('id')->on('usr_usuarios');
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
        Schema::dropIfExists('gti_chamados_has_status');
    }
}
