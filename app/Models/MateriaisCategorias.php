<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MateriaisCategorias extends Model
{
	use HasFactory;

    protected $table = 'adm_materiais_categorias';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'nome', 'status', 'created_at', 'updated_at'];
}
