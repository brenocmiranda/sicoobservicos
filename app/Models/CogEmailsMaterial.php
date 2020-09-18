<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class CogEmailsMaterial extends Model
{	
	use Notifiable;

    protected $table = 'cog_emails';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'email_material', 'assunto_material', 'abertura_solicitacao_material', 'fechamento_solicitacao_material'];

	public function routeNotificationForMail($notification)
    {
        // Return email address only...
        return $this->email_material;
    }
}
