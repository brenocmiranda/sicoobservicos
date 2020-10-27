<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conglomerado extends Model
{
    use HasFactory;

    protected $table = 'cli_conglomerados';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'codigo', 'descricao', 'cli_id_associado', 'created_at', 'updated_at'];

}
