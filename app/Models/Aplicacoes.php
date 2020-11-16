<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aplicacoes extends Model
{
    use HasFactory;

    protected $table = 'dep_aplicacoes';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'num_conta', 'modalidade', 'tipo', 'valor_correcao', 'valor_inicial', 'valor_saldo', 'data_movimento', 'cco_id_contacorrente', 'cli_id_associado', 'created_at', 'updated_at'];

    public function RelationContaCorrente(){
        return $this->belongsTo(ContaCorrente::class, 'cco_id_contacorrente');
    }
}
