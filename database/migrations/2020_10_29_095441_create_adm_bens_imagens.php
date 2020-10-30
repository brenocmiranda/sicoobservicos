<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmBensImagens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adm_bens_imagens', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->integer('id_imagem')->unsigned();
            $table->integer('id_bens')->unsigned();
            $table->foreign('id_imagem')->references('id')->on('sys_imagens');
            $table->foreign('id_bens')->references('id')->on('adm_bens');

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
        Schema::dropIfExists('adm_bens_imagens');
    }
}
