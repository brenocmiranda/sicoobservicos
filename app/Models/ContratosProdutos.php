<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContratosProdutos extends Model
{
	use HasFactory;

    protected $table = 'cre_produtos';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'codigo', 'nome', 'status', 'created_at', 'updated_at'];
}
