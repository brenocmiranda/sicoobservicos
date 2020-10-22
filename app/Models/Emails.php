<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Emails extends Model
{
	use Notifiable;
	use HasFactory;

    protected $table = 'cli_emails';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'tipo', 'email', 'cli_id_associado', 'created_at', 'updated_at'];
}
