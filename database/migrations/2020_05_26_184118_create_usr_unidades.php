<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsrUnidades extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usr_unidades', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('nome');
            $table->string('cnpj')->nullable();
            $table->string('referencia');
            $table->boolean('status'); // 1 - Ativado | 0 - Desativado
            $table->string('telefone')->nullable();
            $table->string('telefone1')->nullable();
            $table->text('rua')->nullable();
            $table->string('bairro')->nullable();
            $table->string('numero')->nullable();
            $table->text('complemento')->nullable();
            $table->string('cidade')->nullable();
            $table->string('estado')->nullable();
            $table->string('pais')->default('Brasil');
            $table->string('cep')->nullable();

            $table->integer('usr_id_instituicao')->unsigned();
            $table->foreign('usr_id_instituicao')->references('id')->on('usr_instituicoes');

            $table->timestamps();
        });

        DB::table('usr_unidades')->insert(
            array([   
                'nome' => 'SEDE PIRAPORA',
                'referencia' => '4133-00',
                'status' => 1,
                'usr_id_instituicao' => 1,
                ],[   
                'nome' => 'PA VARZEA DA PALMA',
                'referencia' => '4133-01',
                'status' => 1,
                'usr_id_instituicao' => 1,
                ],[   
                'nome' => 'PA BURITIZEIRO',
                'referencia' => '4133-02',
                'status' => 1,
                'usr_id_instituicao' => 1,
                ],[   
                'nome' => 'PA FRANCISCO DUMONT',
                'referencia' => '4133-03',
                'status' => 1,
                'usr_id_instituicao' => 1,
                ],[   
                'nome' => 'PA ENGENHEIRO NAVARRO',
                'referencia' => '4133-05',
                'status' => 1,
                'usr_id_instituicao' => 1,
                ],[   
                'nome' => 'PA ATENDIMENTO DIGITAL',
                'referencia' => '4133-097',
                'status' => 1,
                'usr_id_instituicao' => 1,
                ]
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usr_unidades');
    }
}
