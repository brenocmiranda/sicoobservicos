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
            $table->integer('num_contrato')->unique();
            $table->enum('situacao', ['vigente', 'quitado', 'prejuizo']);
            $table->string('modalidade_conta');
            $table->string('tipo_conta')->nullable();
            $table->string('categoria_conta')->nullable();
            $table->double('taxa_limite');
            $table->integer('utlizacao_limite')->nullable();
            $table->double('valor_contratado');
            $table->double('valor_utilizado')->nullable();
            $table->double('taxa_adp')->nullable();
            $table->integer('utlizacao_adp')->nullable();
            $table->double('valor_adp')->nullable();
            $table->integer('sem_movimentacao')->nullable();
            $table->date('ultima_movimentacao')->nullable();
            $table->date('data_abertura');
            $table->date('data_encerramento')->nullable();
            $table->integer('cli_id_associado')->unsigned();
            $table->foreign('cli_id_associado')->references('id')->on('cli_associados');
            $table->integer('cre_id_arquivo')->unsigned();
            $table->foreign('cre_id_arquivo')->references('id')->on('cre_arquivos');

            $table->date('data_movimento');
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
