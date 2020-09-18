<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Armarios extends Model
{
    protected $table = 'cre_armarios';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'nome', 'referencia', 'status', 'created_at', 'updated_at'];
}
