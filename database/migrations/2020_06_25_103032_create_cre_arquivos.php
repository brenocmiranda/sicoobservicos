<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreArquivos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cre_arquivos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->integer('cre_id_produtos')->unsigned()->nullable();
            $table->foreign('cre_id_produtos')->references('id')->on('cre_produtos');
            $table->integer('cre_id_armarios')->unsigned()->nullable();
            $table->foreign('cre_id_armarios')->references('id')->on('cre_armarios');

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
        Schema::dropIfExists('cre_arquivos');
    }
}
