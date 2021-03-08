<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProSeguros extends Model
{
    use HasFactory;

    protected $table = 'pro_seguros';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'documento', 'nome_associado', 'n_proposta', 'n_apolice', 'corretora', 'seguradora', 'ramo', 'familia', 'premio_bruto', 'premio_liquido', 'comissao', 'data_vigencia', 'data_encerramento', 'cpf_atendente', 'data_movimento', 'cli_id_associado', 'created_at', 'updated_at'];
}
