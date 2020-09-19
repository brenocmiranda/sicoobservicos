<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chamados extends Model
{
    use HasFactory;

    protected $table = 'gti_chamados';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'assunto', 'descricao', 'prioridade', 'avaliacao', 'gti_id_tipos', 'gti_id_fontes', 'usr_id_usuarios', 'created_at', 'updated_at'];

    public function RelationFontes(){
        return $this->belongsTo(Fontes::class, 'gti_id_fontes', 'id');
    }

    public function RelationTipos(){
        return $this->belongsTo(Tipos::class, 'gti_id_tipos', 'id');
    }

    public function RelationUsuario(){
        return $this->belongsTo(Usuarios::class, 'usr_id_usuarios', 'id');
    }

    public function RelationStatus(){
        return $this->belongsToMany(Status::class, 'gti_status_has_chamados', 'gti_id_chamados', 'gti_id_status')->withTimestamps()->withPivot('descricao', 'id')->orderBy('gti_status_has_chamados.created_at', 'DESC');
    }

    public function RelationStatus1(){
        return $this->belongsTo(ChamadosStatus::class, 'id', 'gti_id_chamados');
    }

    public function RelationImagens(){
        return $this->belongsToMany(Imagens::class, 'gti_chamados_has_imagens', 'gti_id_chamados', 'id_imagem');
    }

    public function RelationChamadosMensagens(){
        return $this->hasMany(ChamadosMensagens::class,'gti_id_chamados', 'id');
    }
}
