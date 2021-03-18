<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NegociosCarteira extends Model
{
    use HasFactory;

    protected $table = 'neg_carteira';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'especial_atual', 'cartao_atual', 'emp_atual', 'fin_atual', 'svida_atual', 'sgeral_atual', 'consorcio_atual', 'previdencia_atual', 'especial_sugerido', 'cartao_sugerido', 'emp_sugerido', 'fin_sugerido', 'svida_sugerido', 'sgeral_sugerido', 'consorcio_sugerido', 'previdencia_sugerido', 'especial_contratado', 'cartao_contratado', 'emp_contratado', 'fin_contratado', 'svida_contratado', 'sgeral_contratado', 'consorcio_contratado', 'previdencia_contratado', 'bc_data', 'bc_consignados', 'bc_creditopessoal', 'bc_chequeespecial', 'bc_cartao', 'bc_financiamento', 'bc_dividavencida', 'se_data', 'se_restricao', 'se_restricao_data', 'se_restricao_tipo', 'se_restricao_valor', 'se_endereco', 'se_telefone', 'cli_id_associado', 'created_at', 'updated_at'];

    public function RelationStatus(){
        return $this->belongsTo(NegociosCarteiraStatus::class, 'id', 'neg_id_carteira')->orderBy('created_at', 'DESC');
    }

    public function RelationAssociado(){
        return $this->belongsTo(Associados::class, 'cli_id_associado');
    }
}
