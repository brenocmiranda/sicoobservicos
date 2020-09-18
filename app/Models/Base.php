<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Base extends Model
{
   	protected $table = 'sup_base';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'titulo', 'subtitulo', 'descricao', 'gti_id_fontes', 'gti_id_tipos', 'created_at', 'updated_at'];

    public function RelationFontes(){
        return $this->belongsTo(Fontes::class, 'gti_id_fontes', 'id');
    }

    public function RelationTipos(){
        return $this->belongsTo(Tipos::class, 'gti_id_tipos', 'id');
    }
}
