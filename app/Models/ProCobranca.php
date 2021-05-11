<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProCobranca extends Model
{
    use HasFactory;

    protected $table = 'pro_cobranca';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'situacao', 'indicador_contrato', 'perfil', 'ramo', 'grupo', 'tipo_dda', 'data_adesao', 'float', 'data_movimento', 'cli_id_associado', 'created_at', 'updated_at'];
}
