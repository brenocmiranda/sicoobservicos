<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IAPs extends Model
{
    use HasFactory;

    protected $table = 'cli_iap';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'indicador_conta_limite', 'indicador_cobranca', 'indicador_consorcio', 'indicador_consorcio_auto', 'indicador_consorcio_imovel', 'indicador_consorcio_servicos', 'indicador_consorcio_moto', 'indicador_conta_capital', 'indicador_credito_rural', 'indicador_cartao_credito', 'indicador_sipag', 'indicador_previdencia', 'indicador_pacotes_tarifa', 'indicador_emprestimo', 'indicador_financiamento', 'indicador_poupanca', 'indicador_rdc', 'indicador_lca', 'indicador_seguro_auto', 'indicador_seguro_massificados', 'indicador_seguro_rural', 'indicador_seguro_vida', 'indicador_prestamista', 'indicador_titulo_descontado', 'produtos_pf', 'produtos_pj', 'data_movimento', 'cli_id_associado', 'created_at', 'updated_at'];
}
