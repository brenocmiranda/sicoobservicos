<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class CogEmailsContrato extends Model
{	
	use Notifiable;
	use HasFactory;

    protected $table = 'cog_emails';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'email_contrato', 'assunto_contrato', 'abertura_solicitacao_contrato', 'fechamento_solicitacao_contrato'];

	public function routeNotificationForMail($notification)
    {
        // Return email address only...
        return $this->email_contrato;
    }
}
