<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProSipagFaturamento extends Model
{
    use HasFactory;

    protected $table = 'pro_sipag_has_faturamento';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'total_cnpj', 'total_master', 'total_visa', 'total_cabal', 'total_credito', 'total_debito', 'total_2_a_6', 'total_7_a_12', 'total_soma_outros', 'data_movimento', 'pro_id_sipag', 'created_at', 'updated_at'];
}
