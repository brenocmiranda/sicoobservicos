<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Avalistas extends Model
{
    protected $table = 'cre_avalistas';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'cli_id_associado', 'cre_id_contrato', 'data_movimento', 'created_at', 'updated_at'];

}
