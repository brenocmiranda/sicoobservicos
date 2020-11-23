<?php

namespace App\Imports;

use App\Models\Associados;
use App\Models\AssociadosIAPs;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class cli_iap implements ToCollection, WithBatchInserts, WithChunkReading, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {   
            $associado = Associados::where('id_sisbr', $row['numero_cliente_sisbr'])->select('id')->first();
            $dados = AssociadosIAPs::where('cli_id_associado', $associado->id)->first();
            if(isset($dados)){
                AssociadosIAPs::where('cli_id_associado', $associado->id)->update([
                    'indicador_conta_limite' => ($row['indicador_produto_cheque_especial_conta_garantida'] == 'SIM' ? 1 : 0), 
                    'indicador_cobranca' => ($row['indicador_produto_cobranca'] == 'SIM' ? 1 : 0), 
                    'indicador_consorcio' => ($row['indicador_produto_consorcio'] == 'SIM' ? 1 : 0), 
                    'indicador_consorcio_auto' => ($row['indicador_produto_consorcio_automovel'] == 'SIM' ? 1 : 0), 
                    'indicador_consorcio_imovel' => ($row['indicador_produto_consorcio_imovel'] == 'SIM' ? 1 : 0), 
                    'indicador_consorcio_servicos' => ($row['indicador_produto_consorcio_servicos'] == 'SIM' ? 1 : 0), 
                    'indicador_consorcio_moto' => ($row['indicador_produto_consorcio_moto'] == 'SIM' ? 1 : 0), 
                    'indicador_conta_capital' => ($row['indicador_produto_conta_capital'] == 'SIM' ? 1 : 0), 
                    'indicador_credito_rural' => ($row['indicador_produto_credito_rural'] == 'SIM' ? 1 : 0), 
                    'indicador_cartao_credito' => ($row['indicador_utilizacao_cartao_credito'] == 'SIM' ? 1 : 0), 
                    'indicador_sipag' => ($row['indicador_utilizacao_sipag'] == 'SIM' ? 1 : 0), 
                    'indicador_previdencia' => ($row['indicador_utilizacao_previdencia'] == 'SIM' ? 1 : 0), 
                    'indicador_pacotes_tarifa' => ($row['indicador_uso_pacote_de_tarifas'] == 'SIM' ? 1 : 0), 
                    'indicador_emprestimo' => ($row['indicador_produto_emprestimo'] == 'SIM' ? 1 : 0), 
                    'indicador_financiamento' => ($row['indicador_produto_financiamento'] == 'SIM' ? 1 : 0), 
                    'indicador_poupanca' => ($row['indicador_produto_poupanca'] == 'SIM' ? 1 : 0), 
                    'indicador_rdc' => ($row['indicador_produto_rdc'] == 'SIM' ? 1 : 0), 
                    'indicador_lca' => ($row['indicador_produto_lca'] == 'SIM' ? 1 : 0), 
                    'indicador_seguro_auto' => ($row['indicador_produto_seguro_auto'] == 'SIM' ? 1 : 0), 
                    'indicador_seguro_massificados' => ($row['indicador_produto_seguro_massificados'] == 'SIM' ? 1 : 0), 
                    'indicador_seguro_rural' => ($row['indicador_produto_seguro_rural'] == 'SIM' ? 1 : 0), 
                    'indicador_seguro_vida' => ($row['indicador_produto_seguro_vida_pfpj'] == 'SIM' ? 1 : 0), 
                    'indicador_prestamista' => ($row['indicador_produto_vida_prestamista'] == 'SIM' ? 1 : 0), 
                    'indicador_titulo_descontado' => ($row['indicador_produto_titulo_descontado'] == 'SIM' ? 1 : 0), 
                    'produtos_pf' => $row['quantidade_produtos_pf'], 
                    'produtos_pj' => $row['quantidade_produtos_pj'], 
                    'data_movimento' => $row['ano_mes_movimento']
                ]);
            }else{
                AssociadosIAPs::create([
                   	'indicador_conta_limite' => ($row['indicador_produto_cheque_especial_conta_garantida'] == 'SIM' ? 1 : 0), 
                    'indicador_cobranca' => ($row['indicador_produto_cobranca'] == 'SIM' ? 1 : 0), 
                    'indicador_consorcio' => ($row['indicador_produto_consorcio'] == 'SIM' ? 1 : 0), 
                    'indicador_consorcio_auto' => ($row['indicador_produto_consorcio_automovel'] == 'SIM' ? 1 : 0), 
                    'indicador_consorcio_imovel' => ($row['indicador_produto_consorcio_imovel'] == 'SIM' ? 1 : 0), 
                    'indicador_consorcio_servicos' => ($row['indicador_produto_consorcio_servicos'] == 'SIM' ? 1 : 0), 
                    'indicador_consorcio_moto' => ($row['indicador_produto_consorcio_moto'] == 'SIM' ? 1 : 0), 
                    'indicador_conta_capital' => ($row['indicador_produto_conta_capital'] == 'SIM' ? 1 : 0), 
                    'indicador_credito_rural' => ($row['indicador_produto_credito_rural'] == 'SIM' ? 1 : 0), 
                    'indicador_cartao_credito' => ($row['indicador_utilizacao_cartao_credito'] == 'SIM' ? 1 : 0), 
                    'indicador_sipag' => ($row['indicador_utilizacao_sipag'] == 'SIM' ? 1 : 0), 
                    'indicador_previdencia' => ($row['indicador_utilizacao_previdencia'] == 'SIM' ? 1 : 0), 
                    'indicador_pacotes_tarifa' => ($row['indicador_uso_pacote_de_tarifas'] == 'SIM' ? 1 : 0), 
                    'indicador_emprestimo' => ($row['indicador_produto_emprestimo'] == 'SIM' ? 1 : 0), 
                    'indicador_financiamento' => ($row['indicador_produto_financiamento'] == 'SIM' ? 1 : 0), 
                    'indicador_poupanca' => ($row['indicador_produto_poupanca'] == 'SIM' ? 1 : 0), 
                    'indicador_rdc' => ($row['indicador_produto_rdc'] == 'SIM' ? 1 : 0), 
                    'indicador_lca' => ($row['indicador_produto_lca'] == 'SIM' ? 1 : 0), 
                    'indicador_seguro_auto' => ($row['indicador_produto_seguro_auto'] == 'SIM' ? 1 : 0), 
                    'indicador_seguro_massificados' => ($row['indicador_produto_seguro_massificados'] == 'SIM' ? 1 : 0), 
                    'indicador_seguro_rural' => ($row['indicador_produto_seguro_rural'] == 'SIM' ? 1 : 0), 
                    'indicador_seguro_vida' => ($row['indicador_produto_seguro_vida_pfpj'] == 'SIM' ? 1 : 0), 
                    'indicador_prestamista' => ($row['indicador_produto_vida_prestamista'] == 'SIM' ? 1 : 0), 
                    'indicador_titulo_descontado' => ($row['indicador_produto_titulo_descontado'] == 'SIM' ? 1 : 0), 
                    'produtos_pf' => $row['quantidade_produtos_pf'], 
                    'produtos_pj' => $row['quantidade_produtos_pj'], 
                    'data_movimento' => $row['ano_mes_movimento'],
                    'cli_id_associado' => Associados::where('id_sisbr', $row['numero_cliente_sisbr'])->select('id')->first()->id,
                ]);
            }
        }
    }

     public function batchSize(): int
    {
        return 1000;
    }
    
    public function chunkSize(): int
    {
        return 1000;
    }
}