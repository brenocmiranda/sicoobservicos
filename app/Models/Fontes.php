<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fontes extends Model
{
	use HasFactory;

    protected $table = 'gti_fontes';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'nome', 'descricao', 'gti_id_ambientes', 'status', 'created_at', 'updated_at'];

    public function RelationAmbientes(){
        return $this->belongsTo(Ambientes::class, 'gti_id_ambientes', 'id');
    }
}
