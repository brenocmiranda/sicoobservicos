<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modalidades extends Model
{
    protected $table = 'cre_modalidades';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'nome', 'codigo', 'sigla', 'status', 'created_at', 'updated_at'];
}
