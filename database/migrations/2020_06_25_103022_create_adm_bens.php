<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmBens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adm_bens', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->boolean('status')->default(1);
            $table->string('nome');
            $table->enum('tipo', ['automovel', 'imovel']);
            $table->text('descricao')->nullable();
            $table->double('valor');
            $table->text('cep')->nullable();
            $table->text('rua')->nullable();
            $table->text('bairro')->nullable();
            $table->text('numero')->nullable();
            $table->text('complemento')->nullable();
            $table->text('cidade')->nullable();
            $table->text('estado')->nullable();
            
            $table->integer('id_imagem')->unsigned()->nullable();
            $table->foreign('id_imagem')->references('id')->on('sys_imagens');
            
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
        Schema::dropIfExists('adm_bens');
    }
}
