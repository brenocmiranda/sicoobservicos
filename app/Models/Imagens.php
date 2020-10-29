<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imagens extends Model
{
	use HasFactory;

    protected $table = 'sys_imagens';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'tipo', 'endereco', 'created_at', 'updated_at'];
}
