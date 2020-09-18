<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Funcoes extends Model
{
   	protected $table = 'usr_funcoes';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'nome', 'status', 'ver_administrativo', 'gerenciar_administrativo', 'ver_credito', 'gerenciar_credito', 'ver_gti', 'gerenciar_gti', 'ver_configuracoes', 'gerenciar_configuracoes', 'created_at', 'updated_at'];
}
