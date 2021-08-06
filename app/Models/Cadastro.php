<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cadastro extends Model
{
    use HasFactory;

    protected $table = 'cad_novos';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'sigla', 'documento', 'nome', 'nome_fantasia', 'data_abertura', 'atividade_economica', 'porte_cliente', 'situacao', 'sexo', 'naturalidade', 'estadoCivil', 'escolaridade', 'profissao', 'email', 'observacoes', 'usr_id_usuarios', 'created_at', 'updated_at'];

    public function RelationUsuario(){
        return $this->belongsTo(Usuarios::class, 'usr_id_usuarios');
    }

    public function RelationStatus(){
        return $this->hasMany(CadastroStatus::class, 'cad_id_novos');
    }

    public function RelationStatusRecente(){
        return $this->belongsTo(CadastroStatus::class, 'id', 'cad_id_novos')->orderBy('cad_novos_has_status.created_at', 'DESC');
    }

    public function RelationTelefones(){
        return $this->hasMany(CadastroTelefones::class, 'cad_id_novos');
    }

    public function RelationSocios(){
        return $this->hasMany(CadastroSocios::class, 'cad_id_novos');
    }

    public function RelationArquivos(){
        return $this->belongsToMany(Arquivos::class, 'cad_novos_has_arquivos', 'cad_id_novos', 'id_arquivo')->withPivot('nome');
    }
}
