<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContratosGarantias extends Model
{
	use HasFactory;

    protected $table = 'cre_garantias';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'tipo', 'descricao', 'cre_id_arquivo', 'data_movimento', 'created_at', 'updated_at'];

}
