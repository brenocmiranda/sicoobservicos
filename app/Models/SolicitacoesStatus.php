<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitacoesStatus extends Model
{
    use HasFactory;

    protected $table = 'cre_solicitacoes_status';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'status', 'usr_id_usuario_alteracao', 'cre_id_solicitacoes', 'created_at', 'updated_at'];

    public function RelationUsuarios(){
    	return $this->belongsTo(Usuarios::class, 'usr_id_usuario_alteracao', 'id');
	}

	public function RelationSolicitacoes(){
    	return $this->belongsTo(Solicitacoes::class, 'cre_id_solicitacoes', 'id');
	}
}
