<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Associados extends Model
{
	use HasFactory;

   	protected $table = 'cli_associados';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'id_sisbr', 'nome', 'nome_fantasia', 'documento', 'tipo_renda', 'renda', 'cod_cnae', 'data_nascimento', 'atividade_economica', 'sexo', 'sigla', 'funcionario', 'data_relacionamento', 'data_renovacao', 'PA', 'nome_gerente', 'descricao_identidade', 'numero_identidade', 'politicamente_exposta', 'profissao', 'created_at', 'updated_at'];

    public function RelationUnidade(){
        return $this->belongsTo(Unidades::class, 'id', 'cli_id_associado');
    }

    public function RelationEnderecos(){
        return $this->belongsTo(Enderecos::class, 'id', 'cli_id_associado');
    }

    public function RelationTelefones(){
        return $this->belongsTo(Telefones::class, 'id', 'cli_id_associado');
    }

    public function RelationEmails(){
        return $this->belongsTo(Emails::class, 'id', 'cli_id_associado');
    }

    public function RelationConsolidado(){
        return $this->belongsTo(AssociadosConsolidado::class, 'id', 'cli_id_associado');
    }
}
