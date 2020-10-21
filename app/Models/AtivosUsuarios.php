<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtivosUsuarios extends Model
{
	use HasFactory;

    protected $table = 'gti_ativos_has_usuarios';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'dataDevolucao', 'dataRecebimento', 'gti_id_ativos', 'usr_id_usuarios', 'created_at', 'updated_at'];

    public function RelationUsuarios(){
        return $this->belongsTo(Usuarios::class, 'usr_id_usuarios', 'id');
    }
}

