<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChamadosStatus extends Model
{
	use HasFactory;

    protected $table = 'gti_chamados_has_status';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'gti_id_chamados', 'gti_id_status', 'usr_id_usuarios', 'descricao', 'created_at', 'updated_at'];

    public function RelationStatus(){
        return $this->belongsTo(Status::class, 'gti_id_status', 'id');
    }

    public function RelationChamado(){
        return $this->belongsTo(Chamados::class, 'gti_id_chamados', 'id');
    }

    public function RelationUsuarios(){
        return $this->hasOne(Usuarios::class, 'id', 'usr_id_usuarios');
    }

    public function RelationStatusArquivos(){
        return $this->belongsToMany(Arquivos::class, 'gti_chamados_has_status_arquivos', 'gti_id_status', 'id_arquivo');
    }
}
