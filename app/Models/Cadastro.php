<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cadastro extends Model
{
    use HasFactory;

    protected $table = 'cad_solicitacoes';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'sigla', 'documento', 'nome', 'fantasia', 'sexo', 'naturalidade', 'estadoCivil', 'escolaridade', 'profissao', 'email', 'observacoes', 'usr_id_usuarios', 'created_at', 'updated_at'];
}
