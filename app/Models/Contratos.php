<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Contratos extends Model
{
    use HasFactory;
    
    protected $table = 'cre_contratos';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'num_contrato', 'situacao', 'modalidade', 'codigo_modalidade', 'sigla_modalidade', 'data_operacao', 'data_vencimento', 'data_quitacao', 'valor_contrato', 'finalidade', 'renegociacao', 'cod_linha', 'linha', 'cli_id_associado', 'cre_id_arquivo', 'taxa_operacao', 'taxa_mora', 'taxa_multa', 'nivel_risco', 'valor_devido', 'qtd_parcelas', 'qtd_parcelas_pagas', 'renegociacao_contrato', 'observacoes', 'data_movimento', 'created_at', 'updated_at'];

    public function RelationGarantias(){
        return $this->hasMany(ContratosGarantias::class, 'cre_id_arquivo', 'cre_id_arquivo');
    }

    public function RelationAvalistas(){
        return $this->hasMany(ContratosAvalistas::class, 'cre_id_arquivo', 'cre_id_arquivo');
    }

    public function RelationAssociados(){
        return $this->belongsTo(Associados::class, 'cli_id_associado', 'id');
    }

    public function RelationArquivos(){
        return $this->belongsTo(ContratosArquivos::class, 'cre_id_arquivo', 'id');
    }

    public function RelationParcelas(){
        return $this->hasMany(ContratosParcelas::class, 'cre_id_contratos');
    }
}