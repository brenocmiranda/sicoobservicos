<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNegCarteiraStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('neg_carteira_status', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('status');
            $table->text('observacoes');

            $table->integer('usr_id_usuarios')->unsigned();
            $table->foreign('usr_id_usuarios')->references('id')->on('usr_usuarios');
            $table->integer('neg_id_carteira')->unsigned();
            $table->foreign('neg_id_carteira')->references('id')->on('neg_carteira');
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
        Schema::dropIfExists('neg_carteira_status');
    }
}
