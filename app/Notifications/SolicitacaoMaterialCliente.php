<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\CogEmailsMaterial;

class SolicitacaoMaterialCliente extends Notification implements ShouldQueue
{
    use Queueable;

    private $material;
    private $configuracoes;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($create)
    {
       $this->material = $create;
       $this->configuracoes = CogEmailsMaterial::first();
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
        if($this->material->status == 0) {
            // Abertura de solicitação
            return (new MailMessage)
                    ->from('servicos@sicoobsertaominas.com.br')
                    ->subject($this->configuracoes->assunto_abertura_material)
                    ->view('system.emails.materialCliente', ['material' => $this->material, 'configuracoes' => $this->configuracoes]);
        }elseif($this->material->status == 1){
            // Aprovação da solicitação
            return (new MailMessage)
                    ->from('servicos@sicoobsertaominas.com.br')
                    ->subject($this->configuracoes->assunto_fechamento_material)
                    ->view('system.emails.materialCliente', ['material' => $this->material, 'configuracoes' => $this->configuracoes]);
        }else{
            // Desaprovação da solicitação
            return (new MailMessage)
                    ->from('servicos@sicoobsertaominas.com.br')
                    ->subject('Cancelamento da sua solicitação =(')
                    ->view('system.emails.materialCliente', ['material' => $this->material, 'configuracoes' => $this->configuracoes]);
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
