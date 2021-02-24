<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCadNovos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cad_novos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->enum('sigla', ['PF', 'PJ']);
            $table->string('documento')->unique();
            $table->string('nome');
            $table->string('fantasia')->nullable();
            $table->date('data_abertura')->nullable();
            $table->string('atividade_economica')->nullable();
            $table->string('porte_cliente')->nullable();
            $table->string('situacao')->nullable();
            $table->string('sexo')->nullable();
            $table->string('naturalidade')->nullable();
            $table->string('estadoCivil')->nullable();
            $table->string('escolaridade')->nullable();
            $table->string('profissao')->nullable();
            $table->string('email')->nullable();
            $table->text('observacoes')->nullable();

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
        Schema::dropIfExists('cad_novos');
    }
}
