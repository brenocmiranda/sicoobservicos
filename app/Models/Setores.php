<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setores extends Model
{
	use HasFactory;

    protected $table = 'usr_setores';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'nome', 'status', 'created_at', 'updated_at'];
}
