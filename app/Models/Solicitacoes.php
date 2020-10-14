<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitacoes extends Model
{
    use HasFactory;

    protected $table = 'cre_solicitacoes';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'observacoes', 'status', 'usr_id_usuario', 'cre_id_contratos', 'created_at', 'updated_at'];

    public function RelationContratos(){
    	return $this->belongsTo(Contratos::class, 'cre_id_contratos', 'id');
	}

	public function RelationUsuarios(){
    	return $this->belongsTo(Usuarios::class, 'usr_id_usuario', 'id');
	}
}
