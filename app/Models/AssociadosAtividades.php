<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssociadosAtividades extends Model
{
    use HasFactory;

    protected $table = 'cli_atividades';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'tipo', 'descricao', 'contato', 'cli_id_associado', 'usr_id_usuario', 'created_at', 'updated_at'];

    public function RelationAssociado(){
        return $this->belongsTo(Associados::class, 'cli_id_associado');
    }

    public function RelationUsuarios(){
        return $this->belongsTo(Usuarios::class, 'usr_id_usuario');
    }
}
