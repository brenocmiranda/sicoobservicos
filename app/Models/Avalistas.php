<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Avalistas extends Model
{
    protected $table = 'cre_avalistas';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'codigo', 'cli_id_associado', 'cre_id_arquivo', 'data_movimento', 'created_at', 'updated_at'];

    public function RelationContrato(){
    	return $this->belongsTo(Contratos::class, 'cre_id_contrato', 'id');
	}

	public function RelationAssociados(){
    	return $this->belongsTo(Associados::class, 'cli_id_associado', 'id');
	}
}
