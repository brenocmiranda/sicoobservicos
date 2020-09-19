<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materiais extends Model
{
	use HasFactory;

    protected $table = 'sup_materiais';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'nome', 'descricao', 'quantidade', 'quantidade_min', 'status', 'id_categoria', 'created_at', 'updated_at'];

    public function RelationCategoria(){
    	return $this->belongsTo(MateriaisCategorias::class, 'id_categoria', 'id');
	}
}
