<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Imagens extends Model
{
    protected $table = 'imagens';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'tipo', 'endereco', 'created_at', 'updated_at'];
}
