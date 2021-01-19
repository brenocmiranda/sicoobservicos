<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGtiChamados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gti_chamados', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('assunto');
            $table->longtext('descricao')->nullable();
            $table->string('prioridade')->nullable();
            $table->string('avaliacao')->nullable();

            $table->integer('gti_id_ambientes')->unsigned();
            $table->foreign('gti_id_ambientes')->references('id')->on('gti_ambientes');
            $table->integer('gti_id_fontes')->unsigned();
            $table->foreign('gti_id_fontes')->references('id')->on('gti_fontes');
            $table->integer('usr_id_usuarios')->unsigned();
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
        Schema::dropIfExists('gti_chamados');
    }
}
