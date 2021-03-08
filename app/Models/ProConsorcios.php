<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProConsorcios extends Model
{
    use HasFactory;

    protected $table = 'pro_consorcios';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'n_contrato', 'grupo', 'cota', 'versao', 'situacao', 'taxa_administracao', 'prazo', 'parcelas_pagas', 'segmento', 'tipo_contemplacao', 'prazo_pagamento', 'forma_pagamento', 'bem_referencia', 'data_adesao', 'data_cancelamento', 'valor_contratado', 'data_movimento', 'cli_id_associado', 'created_at', 'updated_at'];
}
