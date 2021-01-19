<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chamados extends Model
{
    use HasFactory;

    protected $table = 'gti_chamados';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'assunto', 'descricao', 'prioridade', 'avaliacao', 'gti_id_fontes', 'gti_id_ambientes', 'usr_id_usuarios', 'created_at', 'updated_at'];

    public function RelationAmbientes(){
        return $this->belongsTo(Ambientes::class, 'gti_id_ambientes', 'id');
    }

    public function RelationFontes(){
        return $this->belongsTo(Fontes::class, 'gti_id_fontes', 'id');
    }

    public function RelationUsuario(){
        return $this->belongsTo(Usuarios::class, 'usr_id_usuarios', 'id');
    }

    public function RelationStatus(){
        return $this->belongsToMany(Status::class, 'gti_chamados_has_status', 'gti_id_chamados', 'gti_id_status')->withPivot('descricao', 'id', 'usr_id_usuarios')->withTimestamps()->orderBy('gti_chamados_has_status.created_at', 'DESC');
    }

    public function RelationStatus1(){
        return $this->belongsTo(ChamadosStatus::class, 'id', 'gti_id_chamados');
    }

    public function RelationArquivos(){
        return $this->belongsToMany(Arquivos::class, 'gti_chamados_has_arquivos', 'gti_id_chamados', 'id_arquivo');
    }

    public function RelationChamadosMensagens(){
        return $this->hasMany(ChamadosMensagens::class, 'gti_id_chamados', 'id');
    }
}
