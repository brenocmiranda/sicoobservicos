<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'gti_status';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'nome', 'tempo', 'color', 'status', 'open', 'finish', 'created_at', 'updated_at'];

    public function RelationStatus(){
        return $this->belongsToMany(Status::class, 'gti_status_has_chamados', 'gti_id_chamados', 'id');
    }
}
