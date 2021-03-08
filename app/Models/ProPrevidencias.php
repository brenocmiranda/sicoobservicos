<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProPrevidencias extends Model
{
    use HasFactory;

    protected $table = 'pro_previdencias';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'documento', 'n_registro', 'aposentadoria', 'autopatrocionio', 'resgate', 'beneficioproporiconal', 'data_adesao', 'data_desligamento', 'situacao_participante', 'tipo_participante', 'forma_pagamento', 'plano', 'regime', 'peculio_morte', 'peculio_invalidez', 'valor_proposta', 'data_movimento', 'cli_id_associado', 'created_at', 'updated_at'];
}
