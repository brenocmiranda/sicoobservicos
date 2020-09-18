<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
	protected $table = 'arquivos';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'tipo', 'endereco', 'created_at', 'updated_at'];
}
