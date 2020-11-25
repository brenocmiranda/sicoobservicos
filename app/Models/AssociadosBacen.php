<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssociadosBacen extends Model
{
    use HasFactory;

    protected $table = 'cli_bacen';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'codigo', 'data_movimento', 'modalidade', 'submodalidade', 'saldo_prejuizo', 'saldo_responsabilidade', 'cli_id_associado', 'saldo_avencer', 'saldo_avencer_30', 'saldo_avencer_3160', 'saldo_avencer_6190', 'saldo_avencer_91180', 'saldo_avencer_181360', 'saldo_avencer_361720', 'saldo_avencer_7211080', 'saldo_avencer_10811440', 'saldo_avencer_14411800', 'saldo_avencer_18015400', 'saldo_avencer_5400', 'saldo_avencer_indeterminado', 'saldo_vencido', 'saldo_vencido_1530', 'saldo_vencido_3160', 'saldo_vencido_6190', 'saldo_vencido_91120', 'saldo_vencido_121150', 'saldo_vencido_151180', 'saldo_vencido_181240', 'saldo_vencido_241300', 'saldo_vencido_301360', 'saldo_vencido_361540', 'saldo_vencido_540', 'saldo_vencido_ate90', 'saldo_vencido_acima90', 'created_at', 'updated_at'];
}
