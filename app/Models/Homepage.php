<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Homepage extends Model
{
	use HasFactory;

   	protected $table = 'gti_homepage';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'titulo', 'subtitulo', 'endereco', 'id_imagem', 'created_at', 'updated_at'];

    public function RelationImagem(){
    	return $this->belongsTo(Imagens::class, 'id_imagem', 'id');
	}
}
