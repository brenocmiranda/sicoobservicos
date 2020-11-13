<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poupancas extends Model
{
    use HasFactory;

    protected $table = 'pop_poupanca';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'num_conta', 'situacao', 'tipo_conta', 'tipo_poupanca', 'data_abertura', 'valor_saldo', 'data_movimento', 'cli_id_associado', 'created_at', 'updated_at' ];
}
