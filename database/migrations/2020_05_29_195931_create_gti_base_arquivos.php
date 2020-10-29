<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGtiBaseArquivos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gti_base_arquivos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('gti_id_topico')->unsigned();
            $table->foreign('gti_id_topico')->references('id')->on('gti_base');
            $table->integer('id_arquivo')->unsigned();
            $table->foreign('id_arquivo')->references('id')->on('sys_arquivos');

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
        Schema::dropIfExists('gti_base_arquivos');
    }
}
