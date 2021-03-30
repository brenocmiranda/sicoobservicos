<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\CogEmailsMaterial;

class SolicitacaoMaterialAdmin extends Notification implements ShouldQueue
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
         // Abertura de solicitação
        if($this->material[0]->status == 0){
            return (new MailMessage)
                    ->from('sertaominass@gmail.com', 'Sicoob Serviços')
                    ->subject('Nova solicitação de material =)')
                    ->view('system.emails.materialAdmin', ['material' => $this->material, 'configuracoes' => $this->configuracoes]);
        }else{
            return (new MailMessage)
                    ->from('sertaominass@gmail.com', 'Sicoob Serviços')
                    ->subject('Cancelamento de solicitação de material =(')
                    ->view('system.emails.materialAdmin', ['material' => $this->material, 'configuracoes' => $this->configuracoes]);
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
