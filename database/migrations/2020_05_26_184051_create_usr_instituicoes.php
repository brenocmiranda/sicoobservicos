<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsrInstituicoes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usr_instituicoes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->string('telefone');
            $table->string('email');
            $table->boolean('status');
            
            $table->timestamps();
        });

        DB::table('usr_instituicoes')->insert(
            array([   
                'nome' => 'SICOOB SERTÃO MINAS',
                'descricao' => 'Cooperativa de Crédito de Livre Admissão do Sertão de Minas Gerais Ltda - Sicoob Sertão Minas',
                'telefone' => '(38) 3742-6250',
                'email' => 'administrativo@sicoobsertaominas.com.br',
                'status' => '1',
                ])
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usr_instituicoes');
    }
}
