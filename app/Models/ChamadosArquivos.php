<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChamadosArquivos extends Model
{
    protected $table = 'gti_chamados_has_arquivos';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'gti_id_chamados', 'id_arquivo', 'created_at', 'updated_at'];
}
