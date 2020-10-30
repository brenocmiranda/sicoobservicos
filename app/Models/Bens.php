<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bens extends Model
{
    use HasFactory;

    protected $table = 'adm_bens';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'status', 'nome', 'tipo', 'descricao', 'valor', 'cep', 'rua', 'bairro', 'numero', 'complemento', 'cidade', 'estado', 'id_imagem', 'created_at', 'updated_at'];

     public function RelationImagemPrincipal(){
    	return $this->belongsTo(Imagens::class, 'id_imagem', 'id');
	}

    public function RelationImagem(){
    	return $this->belongsToMany(Imagens::class, 'adm_bens_imagens', 'id_bens', 'id_imagem');
	}
}
