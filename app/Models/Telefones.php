<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Telefones extends Model
{
	use HasFactory;

    protected $table = 'cli_telefones';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'tipo', 'numero', 'data_movimento', 'cli_id_associado', 'created_at', 'updated_at'];

}
