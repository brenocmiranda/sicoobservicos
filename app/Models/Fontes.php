<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fontes extends Model
{
    protected $table = 'gti_fontes';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'nome', 'descricao', 'status', 'created_at', 'updated_at'];
}
