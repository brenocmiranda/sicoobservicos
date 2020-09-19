<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuarios extends Authenticatable
{
    use Notifiable;
    use HasFactory;
    
    protected $table = 'usr_usuarios';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'login', 'password', 'email', 'email_verified_at', 'telefone', 'remember_token', 'status', 'usr_id_setor', 'usr_id_funcao', 'usr_id_instituicao', 'usr_id_unidade', 'cli_id_associado', 'id_imagem', 'created_at', 'updated_at'];

    public function RelationSetor(){
    	return $this->belongsTo(Setores::class, 'usr_id_setor', 'id');
	}

	public function RelationFuncao(){
    	return $this->belongsTo(Funcoes::class, 'usr_id_funcao', 'id');
	}

    public function RelationInstituicao(){
        return $this->belongsTo(Instituicoes::class, 'usr_id_instituicao', 'id');
    }

    public function RelationUnidade(){
        return $this->belongsTo(Unidades::class, 'usr_id_unidade', 'id');
    }

	public function RelationAssociado(){
    	return $this->belongsTo(Associados::class, 'cli_id_associado', 'id');
	}

	public function RelationImagem(){
    	return $this->belongsTo(Imagens::class, 'id_imagem', 'id');
	}

    public function RelationAtividades(){
        return $this->belongsTo(Atividades::class, 'id', 'id_usuario');
    }
}
