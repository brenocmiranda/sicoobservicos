<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChamadosImagens extends Model
{
   	protected $table = 'gti_chamados_has_imagens';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'gti_id_chamados', 'id_imagem', 'created_at', 'updated_at'];
}
