<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContratosArmarios extends Model
{	
	use HasFactory;

    protected $table = 'cre_armarios';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'nome', 'referencia', 'status', 'created_at', 'updated_at'];
}
