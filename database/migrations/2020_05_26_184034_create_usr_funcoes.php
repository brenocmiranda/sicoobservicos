<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsrFuncoes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usr_funcoes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('nome');
            $table->boolean('status');
            $table->boolean('ver_administrativo');
            $table->boolean('gerenciar_administrativo');
            $table->boolean('ver_credito');
            $table->boolean('gerenciar_credito');
            $table->boolean('ver_gti');
            $table->boolean('gerenciar_gti');
            $table->boolean('ver_configuracoes');
            $table->boolean('gerenciar_configuracoes');
            $table->boolean('ver_cadastro');
            $table->boolean('gerenciar_cadastro');
            $table->boolean('ver_produtos');
            $table->boolean('gerenciar_produtos');
            $table->boolean('ver_atendimento');
            $table->boolean('gerenciar_atendimento');
            $table->boolean('ver_negocios');
            $table->boolean('gerenciar_negocios');
            $table->boolean('ver_suporte');
            $table->timestamps();
        });

        DB::table('usr_funcoes')->insert(
            array([   
                'nome' => 'Administradores',
                'status' => 1,
                'ver_administrativo' => 1,
                'gerenciar_administrativo' => 1,
                'ver_credito' => 1,
                'gerenciar_credito' => 1,
                'ver_gti' => 1,
                'gerenciar_gti' => 1,
                'ver_configuracoes' => 1,
                'gerenciar_configuracoes' => 1,
                'ver_cadastro' => 1,
                'gerenciar_cadastro' => 1,
                'ver_produtos' => 1,
                'gerenciar_produtos' => 1,
                'ver_atendimento' => 1,
                'gerenciar_atendimento' => 1,
                'ver_negocios' => 1,
                'gerenciar_negocios' => 1,
                'ver_suporte' => 1
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
        Schema::dropIfExists('usr_funcoes');
    }
}
