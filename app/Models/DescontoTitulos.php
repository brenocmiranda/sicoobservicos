<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DescontoTitulos extends Model
{
    use HasFactory;

    protected $table = 'dct_titdescontados';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'num_contrato', 'situacao_contrato', 'data_operacao', 'data_vencimento', 'valor_contrato', 'observacoes', 'cli_id_associado', 'cre_id_arquivo', 'created_at', 'updated_at'];
}
