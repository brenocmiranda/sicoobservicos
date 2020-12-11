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
    protected $fillable = ['id', 'num_contrato', 'situacao', 'finalidade', 'data_operacao', 'data_vencimento', 'valor_contrato', 'renegociacao', 'renegociacao_contrato', 'observacoes', 'cli_id_associado', 'cre_id_arquivo', 'nivel_risco', 'taxa_operacao', 'taxa_mora', 'taxa_multa', 'valor_devido', 'valor_pago', 'qtd_parcelas', 'qtd_parcelas_abertas', 'qtd_parcelas_pagas', 'data_movimento', 'created_at', 'updated_at'];

    public function RelationUnidade(){
        return $this->belongsTo(Unidades::class, 'cli_id_unidade', 'id');
    }

    public function RelationGarantias(){
        return $this->hasMany(Garantias::class,'cre_id_contrato');
    }

    public function RelationAvalistas(){
        return $this->belongsToMany(Associados::class, 'cre_avalistas', 'cre_id_contrato', 'cli_id_associado');
    }


    public function RelationFinalidades(){
        return $this->belongsTo(Finalidades::class, 'cre_id_finalidades', 'id');
    }

    public function RelationAssociados(){
        return $this->belongsTo(Associados::class, 'cli_id_associado', 'id');
    }

    public function RelationArquivos(){
        return $this->belongsTo(ContratosArquivos::class, 'cre_id_arquivo', 'id');
    }
}
