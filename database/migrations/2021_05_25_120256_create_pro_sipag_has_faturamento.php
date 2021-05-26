<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProSipagHasFaturamento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pro_sipag_has_faturamento', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->date('data_movimento');
            $table->double('total_cnpj');
            $table->double('total_master');
            $table->double('total_visa');
            $table->double('total_cabal');
            $table->double('total_credito');
            $table->double('total_debito');
            $table->double('total_2_a_6');
            $table->double('total_7_a_12');
            $table->double('total_soma_outros');

            $table->integer('pro_id_sipag')->unsigned();
            $table->foreign('pro_id_sipag')->references('id')->on('pro_sipag');
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
        Schema::dropIfExists('pro_sipag_has_faturamento');
    }
}
