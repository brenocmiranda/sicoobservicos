<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AtivosImagens extends Model
{
    protected $table = 'gti_ativos_has_imagens';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'id_ativo', 'id_imagem', 'created_at', 'updated_at'];
}
