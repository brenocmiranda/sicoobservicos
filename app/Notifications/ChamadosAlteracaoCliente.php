<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ChamadosAlteracaoCliente extends Notification implements ShouldQueue
{
    use Queueable;

    private $chamado;
    private $configuracoes;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($chamado)
    {
        $this->chamado = $chamado;
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
        return (new MailMessage)
                    ->from('breno.miranda@sicoobsertaominas.com.br')
                    ->subject('Temos novidades no seu chamado =)')
                    ->view('system.emails.chamadoAlteracaoCliente', ['chamado' => $this->chamado]);
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
