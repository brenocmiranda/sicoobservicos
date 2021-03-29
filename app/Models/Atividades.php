<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atividades extends Model
{
    use HasFactory;

    protected $table = 'sys_activities';
    protected $primaryKey = 'id';
    protected $fillable = [ 'id', 'nome', 'descricao', 'icone', 'url', 'status', 'id_usuario', 'created_at', 'updated_at'];

    public function RelationUsuarios(){
        return $this->belongsTo(Usuarios::class, 'id_usuario');
    }
}
