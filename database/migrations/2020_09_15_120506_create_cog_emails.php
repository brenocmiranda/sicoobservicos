<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCogEmails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cog_emails', function (Blueprint $table) {
          $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('email_chamado');
            $table->string('assunto_chamado');
            $table->text('abertura_chamado');
            $table->text('fechamento_chamado');
            $table->string('email_material');
            $table->string('assunto_material');
            $table->text('abertura_solicitacao_material');
            $table->text('fechamento_solicitacao_material');
            $table->string('email_contrato');
            $table->string('assunto_contrato');
            $table->text('abertura_solicitacao_contrato');
            $table->text('fechamento_solicitacao_contrato');

            $table->timestamps();
        });

        $dados = DB::table('cog_emails')->insert(
            array([   
                'email_chamado' => 'ti@sicoobsertaominas.com.br',
                'assunto_chamado' => 'Seu chamado foi aberto :)',
                'abertura_chamado' => 'Seu chamado foi aberto com sucesso!',
                'fechamento_chamado' => 'Seu chamado foi finalizado com sucesso!',

                'email_material' => 'administrativo@sicoobsertaominas.com.br',
                'assunto_material' => 'Recebemos sua solicitação =)',
                'abertura_solicitacao_material' => '<p><span style="font-weight: bold;" bold;="" font-size:="" 14px;\"="">Ebaa, recebemos sua solicitação de materiais!</span></p><p>Os itens estão sendo separados para entrega, aguarde alguns minutos para novas atualizações.</p>',
                'fechamento_solicitacao_material' => 'Sua solicitação foi aprovada!',
                
                'email_contrato' => 'credito@sicoobsertaominas.com.br',
                'assunto_contrato' => 'Recebemos sua solicitação =)',
                'abertura_solicitacao_contrato' => 'Sua solicitação foi recebida! Aguarde até que seja aprovada.',
                'fechamento_solicitacao_contrato' => 'Sua solicitação foi aprovada!',
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
        Schema::dropIfExists('cog_emails');
    }
}
