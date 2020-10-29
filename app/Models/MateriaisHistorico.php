<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MateriaisHistorico extends Model
{
	use HasFactory;

    protected $table = 'adm_materiais_historico';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'tipo', 'quantidade', 'id_material', 'id_usuario', 'status', 'created_at', 'updated_at'];

    public function RelationMaterial(){
    	return $this->belongsTo(Materiais::class, 'id_material', 'id');
	}

	public function RelationUsuario(){
    	return $this->belongsTo(Usuarios::class, 'id_usuario', 'id');
	}
}
