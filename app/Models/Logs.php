<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    use HasFactory;

    protected $table = 'sys_logs';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'mensagem', 'created_at', 'updated_at'];

}