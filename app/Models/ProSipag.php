<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProSipag extends Model
{
    use HasFactory;

    protected $table = 'pro_sipag';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'ec', 'base', 'mcc', 'descricao_mcc', 'segmento', 'cnae', 'descricao_cnae', 'data_credenciamento', 'status', 'ecommerce', 'data_movimento', 'cli_id_associado', 'created_at', 'updated_at'];
}
