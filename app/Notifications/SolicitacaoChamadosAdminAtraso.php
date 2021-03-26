<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\CogEmailsChamado;

class SolicitacaoChamadosAdminAtraso extends Notification implements ShouldQueue
{
    use Queueable;

    private $todos;
    private $configuracoes;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($atrasados)
    {
        $this->todos = $atrasados;
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
        if(count($this->todos) == 1){
            return (new MailMessage)
                ->from('sertaominass@gmail.com', 'Sicoob Serviços')
                ->subject('Você possui um chamado pendente!')
                ->view('system.emails.chamadoAdminAtraso', ['todos' => $this->todos]);
        }elseif(count($this->todos) > 1){
             return (new MailMessage)
                ->from('sertaominass@gmail.com', 'Sicoob Serviços')
                ->subject('Você possui alguns chamados pendentes!')
                ->view('system.emails.chamadoAdminAtraso', ['todos' => $this->todos]);
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
