<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGtiBase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gti_base', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('titulo');
            $table->string('subtitulo');
            $table->longText('descricao');

            $table->integer('gti_id_ambientes')->unsigned();
            $table->foreign('gti_id_ambientes')->references('id')->on('gti_ambientes');
            $table->integer('gti_id_fontes')->unsigned();
            $table->foreign('gti_id_fontes')->references('id')->on('gti_fontes');

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
        Schema::dropIfExists('gti_base');
    }
}
