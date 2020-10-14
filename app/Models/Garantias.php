<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Garantias extends Model
{
	use HasFactory;

    protected $table = 'cre_garantias';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'tipo', 'descricao', 'cre_id_contrato', 'data_movimento', 'created_at', 'updated_at'];

	public function RelationContrato(){
    	return $this->belongsTo(Contratos::class, 'cre_id_contrato', 'id');
	}
}
