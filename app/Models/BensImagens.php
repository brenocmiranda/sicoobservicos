<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BensImagens extends Model
{
    use HasFactory;

    protected $table = 'adm_bens_imagens';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'id_imagem', 'id_bens', 'created_at', 'updated_at'];
}
