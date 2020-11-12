<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContaCorrente extends Model
{
    use HasFactory;

    protected $table = 'cco_contacorrente';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'num_contrato', 'situacao', 'modalidade_conta', 'tipo_conta', 'categoria_conta', 'taxa_limite', 'utilizacao_limite', 'valor_contratado', 'valor_utilizado', 'taxa_adp', 'utilizacao_adp', 'valor_adp', 'sem_movimentacao', 'ultima_movimentacao', 'data_abertura', 'data_encerramento', 'cli_id_associado', 'cre_id_arquivo', 'data_movimento', 'created_at', 'updated_at'];
}
