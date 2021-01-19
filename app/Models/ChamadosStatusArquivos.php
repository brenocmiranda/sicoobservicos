<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChamadosStatusArquivos extends Model
{
    use HasFactory;

    protected $table = 'gti_chamados_has_status_arquivos';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'gti_id_status', 'id_arquivo', 'created_at', 'updated_at'];
}
