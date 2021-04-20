<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Fampe extends Notification
{
    use Queueable;

    private $operacoesOntem;
    private $operacoes;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($operacoesOntem)
    {
        $this->operacoesOntem = $operacoesOntem;
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
                ->subject('Operações do FAMPE')
                ->view('system.emails.fampe', ['operacoesOntem' => $this->operacoesOntem]);
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