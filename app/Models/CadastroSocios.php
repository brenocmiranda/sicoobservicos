<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CadastroSocios extends Model
{
    use HasFactory;

    protected $table = 'cad_solicitacoes_has_socios';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'cad_id_solicitacoes', 'cli_id_associado', 'created_at', 'updated_at'];

    public function RelationSolicitacao(){
        return $this->hasMany(Cadastro::class, 'cad_id_solicitacoes');
    }
}
