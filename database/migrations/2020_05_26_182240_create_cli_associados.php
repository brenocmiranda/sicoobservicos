<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCliAssociados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cli_associados', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('id_sisbr')->unique();
            $table->text('nome');
            $table->string('nome_fantasia');
            $table->string('documento')->unique();
            $table->string('tipo_renda');
            $table->double('renda');
            $table->string('cod_cnae');
            $table->date('data_nascimento');
            $table->string('atividade_economica');
            $table->string('sexo');
            $table->string('sigla');
            $table->boolean('funcionario');
            $table->date('data_relacionamento');
            $table->date('data_renovacao');
            $table->string('PA');

            $table->timestamps();
        });

        DB::table('cli_associados')->insert(
            array([   
                'id_sisbr' => '99999',
                'nome' => 'Administrador Master',
                'nome_fantasia' => 'Administrador do sistema',
                'documento' => '12345678912',
                'tipo_renda' => 'SALARIO',
                'renda' => '0',
                'cod_cnae' => '-2',
                'data_nascimento' => '2020-01-01',
                'atividade_economica' => 'MANUTENCAO NO SISTEMA',
                'sexo' => 'M',
                'sigla' => 'PJ',
                'funcionario' => '1',
                'data_relacionamento' => '2020-01-01 00:00:00',
                'data_renovacao' => '2020-01-01 00:00:00',
                'PA' => 'SEDE PIRAPORA',
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
        Schema::dropIfExists('cli_associados');
    }
}
