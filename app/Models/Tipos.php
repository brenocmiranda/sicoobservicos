<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tipos extends Model
{
    protected $table = 'gti_tipos';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'nome', 'descricao', 'gti_id_fontes', 'status', 'created_at', 'updated_at'];

    public function RelationTipos(){
        return $this->belongsTo(Fontes::class, 'gti_id_fontes', 'id');
    }
}
