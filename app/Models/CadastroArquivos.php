<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CadastroArquivos extends Model
{
    use HasFactory;

    protected $table = 'cad_novos_has_arquivos';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'nome', 'id_arquivo', 'cad_id_novos', 'created_at', 'updated_at'];

   	public function RelationCadastro(){
        return $this->belongsTo(Cadastro::class, 'cad_id_novos');
    }
}
