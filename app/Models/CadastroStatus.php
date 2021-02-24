<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CadastroStatus extends Model
{
    use HasFactory;

    protected $table = 'cad_novos_has_status';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'status', 'descricao', 'usr_id_usuarios', 'cad_id_novos', 'created_at', 'updated_at'];
    
    public function RelationCadastro(){
        return $this->belongsTo(Cadastro::class, 'cad_id_novos');
    }
}
