<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContaCapital extends Model
{
    use HasFactory;

    protected $table = 'cca_contacapital';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'num_capital', 'situacao_capital', 'direito_voto', 'direito_rateio', 'data_matricula', 'saida_matricula', 'valor_integralizado', 'data_movimento', 'cli_id_associado', 'created_at', 'updated_at'];

    public function RelationCarteiraNegocios(){
        return $this->belongsTo(NegociosCarteira::class, 'cli_id_associado', 'cli_id_associado');
    }
}
