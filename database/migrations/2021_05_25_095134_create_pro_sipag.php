<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProSipag extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pro_sipag', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('ec');
            $table->string('base');
            $table->string('domicilio_banco')->nullable();
            $table->string('domicilio_agencia')->nullable();
            $table->string('descricao_mcc')->nullable();
            $table->string('segmento')->nullable();
            $table->date('data_credenciamento');
            $table->string('status');

            $table->integer('cli_id_associado')->unsigned()->nullable();
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
        Schema::dropIfExists('pro_sipag');
    }
}
