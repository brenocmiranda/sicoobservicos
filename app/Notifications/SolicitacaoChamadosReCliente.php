<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\CogEmailsChamado;

class SolicitacaoChamadosReCliente extends Notification implements ShouldQueue
{
    use Queueable;

    private $chamado;
    private $configuracoes;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($create)
    {
        $this->chamado = $create;
        $this->configuracoes = CogEmailsChamado::first();
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
                ->from('sertaominass@gmail.com', 'Sicoob Serviços')
                ->subject('Reabertura de chamado')
                ->view('system.emails.chamadoReCliente', ['chamado' => $this->chamado, 'configuracoes' => $this->configuracoes]);
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
