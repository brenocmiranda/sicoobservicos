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
            $table->string('assunto_abertura_chamado');
            $table->longText('abertura_chamado');
            $table->string('assunto_fechamento_chamado');
            $table->longText('fechamento_chamado');
            $table->string('email_material');
            $table->string('assunto_abertura_material');
            $table->longText('abertura_solicitacao_material');
            $table->string('assunto_fechamento_material');
            $table->longText('fechamento_solicitacao_material');
            $table->string('email_contrato');
            $table->string('assunto_abertura_contrato');
            $table->longText('abertura_solicitacao_contrato');
            $table->string('assunto_fechamento_contrato');
            $table->longText('fechamento_solicitacao_contrato');

            $table->timestamps();
        });

        $dados = DB::table('cog_emails')->insert(
            array([   
                'email_chamado' => 'ti@sicoobsertaominas.com.br',
                'assunto_abertura_chamado' => 'Seu chamado foi aberto :)',
                'abertura_chamado' => '<p><span style="font-weight: bold;">Olá, recebemos sua abertura de chamado!</span></p><p>Fique tranquilo que em instantes os responsáveis iram sanar os seus problemas.</p>',
                'assunto_fechamento_chamado' => 'Seu chamado foi aberto :)',
                'fechamento_chamado' => 'Seu chamado foi finalizado com sucesso!',

                'email_material' => 'administrativo@sicoobsertaominas.com.br',
                'assunto_abertura_material' => 'Recebemos sua solicitação =)',
                'abertura_solicitacao_material' => '<p><span style="font-weight: bold;" bold;="" font-size:="" 14px;\"="">Ebaa, recebemos sua solicitação de materiais!</span></p><p>Os itens estão sendo separados para entrega, aguarde alguns minutos para novas atualizações.</p>',
                'assunto_fechamento_material' => 'Recebemos sua solicitação =)',
                'fechamento_solicitacao_material' => 'Sua solicitação foi aprovada!',
                
                'email_contrato' => 'credito@sicoobsertaominas.com.br',
                'assunto_abertura_contrato' => 'Recebemos sua solicitação =)',
                'abertura_solicitacao_contrato' => 'Sua solicitação foi recebida! Aguarde até que seja aprovada.',
                'assunto_fechamento_contrato' => 'Recebemos sua solicitação =)',
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
