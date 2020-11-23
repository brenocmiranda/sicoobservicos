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
        return $this->belongsTo(AssociadosEnderecos::class, 'id', 'cli_id_associado');
    }

    public function RelationTelefones(){
        return $this->belongsTo(AssociadosTelefones::class, 'id', 'cli_id_associado');
    }

    public function RelationEmails(){
        return $this->belongsTo(AssociadosEmails::class, 'id', 'cli_id_associado');
    }

    public function RelationConsolidado(){
        return $this->belongsTo(AssociadosConsolidado::class, 'id', 'cli_id_associado');
    }

    public function RelationCapital(){
        return $this->belongsTo(ContaCapital::class, 'id', 'cli_id_associado');
    }

    public function RelationConglomerados(){
        return $this->belongsTo(AssociadosConglomerados::class, 'id', 'cli_id_associado');
    }

    public function RelationIAP(){
        return $this->belongsTo(AssociadosIAPs::class, 'id', 'cli_id_associado');
    }

    public function RelationContaCorrente(){
        return $this->hasMany(ContaCorrente::class, 'cli_id_associado');
    }

    public function RelationCartaoCredito(){
        return $this->hasMany(CartaoCredito::class, 'cli_id_associado');
    }

    public function RelationCarteiraCredito(){
        return $this->hasMany(Contratos::class, 'cli_id_associado');
    }

    public function RelationPoupancas(){
        return $this->hasMany(Poupancas::class, 'cli_id_associado');
    }

    public function RelationAplicacoes(){
        return $this->hasMany(Aplicacoes::class, 'cli_id_associado');
    }

    public function RelationAtividades(){
        return $this->hasMany(AssociadosAtividades::class, 'cli_id_associado');
    }

    public function RelationBacen(){
        return $this->hasMany(AssociadosBacen::class, 'cli_id_associado');
    }
}
