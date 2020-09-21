<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documentos extends Model
{
    use HasFactory;

    protected $table = 'sup_documentos';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'nome', 'descricao', 'status', 'id_arquivo', 'created_at', 'updated_at'];

    public function RelationArquivo(){
        return $this->belongsTo(Arquivos::class, 'id_arquivo');
    }
}
