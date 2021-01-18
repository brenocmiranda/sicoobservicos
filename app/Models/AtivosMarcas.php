<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtivosMarcas extends Model
{
    use HasFactory;

    protected $table = 'gti_ativos_has_marcas';
    protected $primaryKey = 'id';
    protected $fillable = [ 'id', 'nome', 'descricao', 'status', 'created_at', 'updated_at'];
}
