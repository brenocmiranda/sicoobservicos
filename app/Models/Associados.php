<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Associados extends Model
{
	use HasFactory;

   	protected $table = 'cli_associados';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'id_sisbr', 'nome', 'nome_fantasia', 'documento', 'tipo_renda', 'renda', 'cod_cnae', 'data_nascimento', 'atividade_economica', 'sexo', 'sigla', 'funcionario', 'data_relacionamento', 'data_renovacao', 'PA', 'created_at', 'updated_at'];

    public function RelationUnidade(){
        return $this->belongsTo(Unidades::class, 'cli_id_unidade', 'id');
    }
}
