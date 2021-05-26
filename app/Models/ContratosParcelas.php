<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContratosParcelas extends Model
{
    use HasFactory;

    protected $table = 'cre_contratos_parcelas';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'num_parcela', 'data_vencimento', 'valor_parcela', 'valor_pago_parcela', 'valor_devedor_parcela', 'valor_juros_parcela', 'dias_atraso', 'situacao', 'data_movimento', 'cre_id_contratos', 'created_at', 'updated_at'];
}
