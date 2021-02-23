<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsrUsuarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usr_usuarios', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('login');
            $table->string('password');
            $table->string('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->integer('attempts')->default(0);
            $table->string('telefone');
            $table->string('telefone_corporativo')->nullable();
            $table->string('telefone_ramal')->nullable();
            $table->rememberToken();
            $table->enum('status', ['Ativo', 'Desativado', 'Bloqueado']);
            $table->integer('usr_id_setor')->unsigned();
            $table->integer('usr_id_funcao')->unsigned();
            $table->integer('usr_id_instituicao')->unsigned();
            $table->integer('usr_id_unidade')->unsigned();
            $table->integer('cli_id_associado')->unsigned();
            $table->integer('id_imagem')->unsigned()->nullable();
            
            $table->foreign('usr_id_setor')->references('id')->on('usr_setores');
            $table->foreign('usr_id_funcao')->references('id')->on('usr_funcoes');
            $table->foreign('usr_id_instituicao')->references('id')->on('usr_instituicoes');
            $table->foreign('usr_id_unidade')->references('id')->on('usr_unidades');
            $table->foreign('cli_id_associado')->references('id')->on('cli_associados');
            $table->foreign('id_imagem')->references('id')->on('sys_imagens');
           
            $table->timestamps();
        });

        DB::table('usr_usuarios')->insert(
            array([   
                'login' => 'administrador',
                'password' => Hash::make('Sicoob4133'),
                'email' => 'breno.miranda@sicoobsertaominas.com.br',
                'email_verified_at' => now(),
                'telefone' => '+5538991680335',
                'remember_token' => csrf_token(),
                'status' => 'Ativo',
                'usr_id_setor' => '1',
                'usr_id_funcao' => '1',
                'usr_id_instituicao' => '1',
                'usr_id_unidade' => '1',
                'cli_id_associado' => '1',
                'id_imagem' => '1',
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
        Schema::dropIfExists('usr_usuarios');
    }
}
