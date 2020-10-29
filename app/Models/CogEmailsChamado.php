<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class CogEmailsChamado extends Model
{	
	use Notifiable;
	use HasFactory;

    protected $table = 'sys_emails';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'email_chamado', 'assunto_abertura_chamado', 'abertura_chamado', 'assunto_fechamento_chamado', 'fechamento_chamado'];

	public function routeNotificationForMail($notification)
    {
        // Return email address only...
        return $this->email_chamado;
    }
}
