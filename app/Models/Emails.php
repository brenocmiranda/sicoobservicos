<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Emails extends Model
{
	use Notifiable;

    protected $table = 'cli_emails';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'tipo', 'email', 'data_movimento', 'cli_id_associado', 'created_at', 'updated_at'];
}
