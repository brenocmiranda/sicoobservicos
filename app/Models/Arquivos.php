<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arquivos extends Model
{
    use HasFactory;

    protected $table = 'arquivos';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'tipo', 'endereco', 'created_at', 'updated_at'];
}
