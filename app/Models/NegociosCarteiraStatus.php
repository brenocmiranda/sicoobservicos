<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NegociosCarteiraStatus extends Model
{
    use HasFactory;

    protected $table = 'neg_carteira_status';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'status', 'observacoes', 'usr_id_usuarios', 'neg_id_carteira', 'created_at', 'updated_at'];

     public function RelationUsuario(){
        return $this->belongsTo(Usuarios::class, 'usr_id_usuarios');
    }

}
