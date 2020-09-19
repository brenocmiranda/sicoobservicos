<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unidades extends Model
{
	use HasFactory;

    protected $table = 'usr_unidades';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'nome', 'referencia', 'status', 'usr_id_instituicao', 'created_at', 'updated_at'];

    public function RelationInstituicao(){
        return $this->belongsTo(Instituicoes::class, 'usr_id_instituicao', 'id');
    }
}
