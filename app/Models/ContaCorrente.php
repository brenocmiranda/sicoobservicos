<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContaCorrente extends Model
{
    use HasFactory;

    protected $table = 'cco_contacorrente';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'num_conta', 'tipo_conta', 'categoria_conta', 'situacao_conta', 'taxa_limite', 'utlizacao_limite', 'valor_contratado', 'valor_limite', 'taxa_adp', 'utlizacao_adp', 'valor_adp', 'sem_movimentacao', 'ultima_movimentacao', 'data_abertura', 'data_movimento', 'cli_id_associado', 'created_at', 'updated_at'];
}
