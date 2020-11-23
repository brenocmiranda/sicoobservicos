<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssociadosEnderecos extends Model
{
    use HasFactory;

    protected $table = 'cli_enderecos';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'rua', 'bairro', 'numero', 'complemento', 'cidade', 'estado', 'pais', 'cli_id_associado', 'created_at', 'updated_at'];
}
