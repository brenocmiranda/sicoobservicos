<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instituicoes extends Model
{
    protected $table = 'usr_instituicoes';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'nome', 'descricao', 'telefone', 'email', 'status', 'created_at', 'updated_at'];
}
