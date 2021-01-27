<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CadastroArquivos extends Model
{
    use HasFactory;

    protected $table = 'cad_solicitacoes_has_arquivos';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'nome', 'id_arquivo', 'cad_id_solicitacoes', 'created_at', 'updated_at'];

    public function RelationSolicitacao(){
        return $this->hasMany(Cadastro::class, 'cad_id_solicitacoes');
    }
}
