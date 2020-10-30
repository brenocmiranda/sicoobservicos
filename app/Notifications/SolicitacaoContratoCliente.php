<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use App\Models\CogEmailsContrato;

class SolicitacaoContratoCliente extends Notification implements ShouldQueue
{
    use Queueable;

    private $contrato;
    private $configuracoes;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($create)
    {
       $this->contrato = $create;
       $this->configuracoes = CogEmailsContrato::first();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if($this->contrato->RelationStatus->last()->status == 'aberto') {
            return (new MailMessage)
                    ->from('servicos@sicoobsertaominas.com.br')
                    ->subject($this->configuracoes->assunto_abertura_contrato)
                    ->view('system.emails.contratoCliente', ['contrato' => $this->contrato, 'configuracoes' => $this->configuracoes]);

        }elseif($this->contrato->RelationStatus->last()->status == 'entregue') {
            return (new MailMessage)
                    ->from('servicos@sicoobsertaominas.com.br')
                    ->subject($this->configuracoes->assunto_fechamento_contrato)
                    ->view('system.emails.contratoCliente', ['contrato' => $this->contrato, 'configuracoes' => $this->configuracoes]);

        }elseif($this->contrato->RelationStatus->last()->status == 'devolvido') {
            return (new MailMessage)
                    ->from('servicos@sicoobsertaominas.com.br')
                    ->subject('Contrato devolvido com sucesso :)')
                    ->view('system.emails.contratoCliente', ['contrato' => $this->contrato, 'configuracoes' => $this->configuracoes]);
        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
