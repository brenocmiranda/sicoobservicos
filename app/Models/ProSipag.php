<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProSipag extends Model
{
    use HasFactory;

    protected $table = 'pro_sipag';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'ec', 'base', 'domicilio_banco', 'domicilio_agencia', 'descricao_mcc', 'segmento', 'data_credenciamento', 'status', 'cli_id_associado', 'created_at', 'updated_at'];

    public function RelationFaturamento(){
        return $this->hasMany(ProSipagFaturamento::class, 'pro_id_sipag');
    }
}
