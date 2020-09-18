<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorias extends Model
{
    protected $table = 'sup_materiais_categorias';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'nome', 'status', 'created_at', 'updated_at'];
}
