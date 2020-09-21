<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class CogEmailsMaterial extends Model
{	
	use Notifiable;
	use HasFactory;

    protected $table = 'cog_emails';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'email_material', 'assunto_abertura_material', 'abertura_solicitacao_material', 'assunto_fechamento_material', 'fechamento_solicitacao_material'];

	public function routeNotificationForMail($notification)
    {
        // Return email address only...
        return $this->email_material;
    }
}
