<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Finalidades extends Model
{
    protected $table = 'cre_finalidades';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'nome', 'status', 'created_at', 'updated_at'];
}
