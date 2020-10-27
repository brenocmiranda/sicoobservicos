<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bens extends Model
{
    use HasFactory;

    protected $table = 'adm_bens';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'nome', 'descricao', 'valor', 'rua', 'bairro', 'numero', 'complemento', 'cidade', 'estado'];

}
