<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssociadosTelefones extends Model
{
	use HasFactory;

    protected $table = 'cli_telefones';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'tipo', 'numero_celular', 'numero_comercial', 'numero_celular', 'numero_residencial', 'numero_fax', 'numero_recado', 'data_movimento', 'cli_id_associado', 'created_at', 'updated_at'];

}
