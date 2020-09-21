<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documentos extends Model
{
    use HasFactory;

    protected $table = 'sup_documentos';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'tipo', 'email', 'data_movimento', 'cli_id_associado', 'created_at', 'updated_at'];
}
}
