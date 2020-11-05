<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartoesCredito extends Model
{
    use HasFactory;

    protected $table = 'crt_cartaocredito';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'num_cartao', 'cod_cliente', 'funcao_cartao', 'produto_cartao', 'bandeira_cartao', 'situacao_cartao', 'fatura', 'venc_fatura', 'data_abertura', 'valor_atribuido', 'valor_disponivel', 'valor_utilizado', 'cli_id_associado', 'created_at', 'updated_at'];
}
