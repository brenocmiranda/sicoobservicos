<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContratosArquivos extends Model
{
    use HasFactory;

    protected $table = 'cre_arquivos';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'cre_id_produtos', 'cre_id_armarios', 'created_at', 'updated_at'];

    public function RelationProdutos(){
        return $this->belongsTo(ContratosProdutos::class, 'cre_id_produtos', 'id');
    }
}
