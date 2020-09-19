<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChamadosStatus extends Model
{
	use HasFactory;

    protected $table = 'gti_status_has_chamados';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'gti_id_chamados', 'gti_id_status', 'descricao', 'created_at', 'updated_at'];

    public function RelationStatus(){
        return $this->belongsTo(Status::class, 'gti_id_status', 'id');
    }
}
