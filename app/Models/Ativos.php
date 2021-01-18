<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ativos extends Model
{
    use HasFactory;

    protected $table = 'gti_ativos';
    protected $primaryKey = 'id';
    protected $fillable = [ 'id', 'n_patrimonio', 'serialNumber', 'serviceTag',  'modelo', 'descricao', 'id_marca', 'id_equipamento', 'id_setor', 'id_unidade', 'id_imagem', 'created_at', 'updated_at'];

    public function RelationImagemPrincipal(){
    	return $this->belongsTo(Imagens::class, 'id_imagem');
	}

	public function RelationImagem(){
    	return $this->belongsToMany(Imagens::class, 'gti_ativos_has_imagens', 'id_ativo', 'id_imagem')->where('tipo', '<>' ,'ativos_principal');
	}

	public function RelationUsuario(){
    	return $this->belongsToMany(Usuarios::class, 'gti_ativos_has_usuarios', 'gti_id_ativos', 'usr_id_usuarios')->withPivot('id');
	}

    public function RelationEquipamento(){
        return $this->belongsTo(AtivosEquipamentos::class, 'id_equipamento');
    }

    public function RelationMarca(){
        return $this->belongsTo(AtivosMarcas::class, 'id_marca');
    }

    public function RelationSetor(){
        return $this->belongsTo(Setores::class, 'id_setor');
    }

    public function RelationUnidade(){
        return $this->belongsTo(Unidades::class, 'id_unidade');
    }
}
