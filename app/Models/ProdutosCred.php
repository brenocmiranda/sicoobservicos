<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdutosCred extends Model
{
    protected $table = 'cre_produtos';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'codigo', 'nome', 'status', 'created_at', 'updated_at'];
}
