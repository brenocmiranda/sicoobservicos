<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Contratos extends Model
{
    protected $table = 'cre_contratos';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'num_contrato', 'status', 'data_operacao', 'data_vencimento', 'valor_contrato', 'renegociacao', 'renegociacao_contrato', 'observacoes', 'cli_id_associado', 'cre_id_modalidades', 'cre_id_finalidades', 'cre_id_produtos', 'cre_id_armarios', 'data_movimento', 'created_at', 'updated_at', 'nivel_risco', 'taxa_operacao', 'taxa_mora', 'taxa_multa', 'valor_devido', 'qtd_parcelas', 'qtd_parcelas_pagas' ];

    public function RelationUnidade(){
        return $this->belongsTo(Unidades::class, 'cli_id_unidade', 'id');
    }

    public function RelationGarantias(){
        return $this->hasMany(Garantias::class,'cre_id_contrato');
    }

    public function RelationAvalistas(){
        return $this->belongsToMany(Associados::class, 'cre_avalistas', 'cre_id_contrato', 'cli_id_associado');
    }

    public function RelationProdutos(){
        return $this->belongsTo(ProdutosCred::class, 'cre_id_produtos', 'id');
    }

    public function RelationModalidades(){
        return $this->belongsTo(Modalidades::class, 'cre_id_modalidades', 'id');
    }

    public function RelationFinalidades(){
        return $this->belongsTo(Finalidades::class, 'cre_id_finalidades', 'id');
    }

    public function RelationAssociados(){
        return $this->belongsTo(Associados::class, 'cli_id_associado', 'id');
    }

    public function RelationArmarios(){
        return $this->belongsTo(Armarios::class, 'cre_id_armarios', 'id');
    }
}
