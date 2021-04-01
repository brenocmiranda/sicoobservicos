<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdmMateriaisHistorico extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adm_materiais_historico', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->enum('tipo', ['e', 's']); // s -> saída  e -> entrada
            $table->integer('quantidade');
            $table->string('quantidade_tipo')->nullable();
            $table->text('motivo')->nullable();
            $table->text('observacoes')->nullable();
            $table->bigInteger('id_material')->unsigned();
            $table->foreign('id_material')->references('id')->on('adm_materiais');
            $table->integer('id_usuario')->unsigned();
            $table->foreign('id_usuario')->references('id')->on('usr_usuarios');
            $table->boolean('status')->default(0); // 0 - Pendente, 1 - Aprovado, 2 - Reprovado

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
        Schema::dropIfExists('adm_materiais_historico');
    }
}
