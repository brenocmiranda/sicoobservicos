<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssociadosConsolidado extends Model
{
    use HasFactory;

    protected $table = 'cli_consolidado';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'nivel_risco', 'nivel_risco_crl', 'data_crl', 'porte_cliente', 'indicador_rural', 'categoria_rural', 'escolaridade', 'estado_civil', 'valor_imovel', 'valor_movel', 'cli_id_associado', 'data_movimento', 'created_at', 'updated_at'];

}
