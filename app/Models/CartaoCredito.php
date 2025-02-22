<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartaoCredito extends Model
{
    use HasFactory;

    protected $table = 'crt_cartaocredito';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'num_contrato', 'situacao', 'cod_cliente', 'funcao_cartao', 'produto_cartao', 'bandeira_cartao', 'fatura', 'venc_fatura', 'data_abertura', 'data_limite', 'data_fechamento', 'valor_atribuido', 'valor_disponivel', 'valor_utilizado', 'data_movimento', 'cli_id_associado', 'cre_id_arquivo', 'created_at', 'updated_at' ];
}
