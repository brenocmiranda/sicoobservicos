<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcoes extends Model
{
	use HasFactory;

   	protected $table = 'usr_funcoes';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'nome', 'status', 'ver_administrativo', 'gerenciar_administrativo', 'ver_credito', 'gerenciar_credito', 'ver_gti', 'gerenciar_gti', 'ver_configuracoes', 'gerenciar_configuracoes', 'ver_cadastro', 'gerenciar_cadastro', 'ver_produtos', 'gerenciar_produtos', 'ver_atendimento', 'gerenciar_atendimento', 'ver_negocios', 'gerenciar_negocios', 'ver_suporte', 'created_at', 'updated_at'];
}
