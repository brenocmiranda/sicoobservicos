<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCcoContacorrente extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cco_contacorrente', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            
            $table->integer('num_conta')->unique();
            $table->string('tipo_conta');
            $table->string('categoria_conta');
            $table->string('situacao_conta');
            $table->double('taxa_limite');
            $table->integer('utlizacao_limite');
            $table->double('valor_contratado');
            $table->double('valor_devedor');
            $table->double('taxa_adp');
            $table->integer('utlizacao_adp');
            $table->double('valor_devedor');
            $table->integer('sem_movimentacao');
            $table->date('ultima_movimentacao');
            $table->date('data_abertura');
            $table->date('data_movimento');
            $table->integer('cli_id_associado')->unsigned();
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
        Schema::dropIfExists('cco_contacorrente');
    }
}
