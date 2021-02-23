<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Base extends Model
{
	use HasFactory;

   	protected $table = 'gti_base';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'titulo', 'subtitulo', 'descricao', 'tipo', 'gti_id_ambientes', 'gti_id_fontes', 'created_at', 'updated_at'];

    public function RelationAmbientes(){
        return $this->belongsTo(Ambientes::class, 'gti_id_ambientes', 'id');
    }

    public function RelationFontes(){
        return $this->belongsTo(Fontes::class, 'gti_id_fontes', 'id');
    }

    public function RelationArquivos(){
        return $this->belongsToMany(Arquivos::class, 'gti_base_arquivos', 'gti_id_topico', 'id_arquivo');
    }
}
