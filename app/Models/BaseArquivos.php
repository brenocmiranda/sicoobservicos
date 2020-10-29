<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseArquivos extends Model
{
    use HasFactory;

    protected $table = 'gti_base_arquivos';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'gti_id_topico', 'id_arquivo', 'created_at', 'updated_at'];

    public function RelationBase(){
        return $this->belongsTo(Base::class, 'gti_id_topico', 'id');
    }
}
