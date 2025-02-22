<?php

namespace App\Imports;

use App\Models\Contratos;
use App\Models\Associados;
use App\Models\ContratosArquivos;
use App\Models\ContratosProdutos;
use App\Models\Logs;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;

class cre_contratos implements ToCollection, WithChunkReading, WithHeadingRow, ShouldQueue, WithEvents
{
    use Importable, RegistersEventListeners;

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {  
            $dados = Contratos::where('num_contrato', $row['numero_contrato_credito'])->first();
            if(isset($dados)){
                ContratosArquivos::find($dados->cre_id_arquivo)->update([
                    'cre_id_produtos' => ContratosProdutos::where('codigo', $row['codigo_produto'])->select('id')->first()->id,
                ]);
                Contratos::where('num_contrato', $row['numero_contrato_credito'])->update([
                    'situacao' => $row['situacao_contrato'],
                    'modalidade' => $row['modalidade_produto'],
                    'codigo_modalidade' => $row['codigo_modalidade_produto'],
                    'sigla_modalidade' => $row['sigla_modalidade_produto'],
                    'data_operacao' => gmdate('Y-m-d', (($row['data_operacao_contrato'] - 25569) * 86400)),
                    'data_vencimento' => gmdate('Y-m-d', (($row['data_vencimento_contrato'] - 25569) * 86400)),
                    'data_quitacao' => ($row['situacao_contrato'] == 'QUITADO' ? gmdate('Y-m-d', (($row['data_movimento'] - 25569) * 86400)) : '1900-01-01'),
                    'valor_contrato' => number_format($row['valor_contrato'], 2, '.', ''),
                    'cli_id_associado' => Associados::where('id_sisbr', $row['numero_cliente_sisbr'])->select('id')->first()->id,
                    'finalidade' => $row['finalidade_operacao_credito'],
                    'renegociacao' => $row['indicador_de_repactuacao'],
                    'cod_linha' => $row['codigo_linha_credito'],
                    'linha' => $row['linha_credito'],
                    'taxa_operacao' => number_format($row['taxa_operacao'], 2, '.', ''),
                    'taxa_mora' => number_format($row['taxa_mora'], 2, '.', ''),
                    'taxa_multa' =>  number_format($row['taxa_multa'], 2, '.', ''),
                    'data_movimento' => gmdate('Y-m-d', (($row['data_movimento'] - 25569) * 86400)),
                    'valor_devido' => ($row['situacao_contrato'] == 'QUITADO' ? 0 : number_format($row['valor_saldo_devedor_diario'], 2, '.', '')),
                    'nivel_risco' => $row['nivel_risco_atual'],
                    'qtd_parcelas' => $row['quantidade_parcelas'],
                    'qtd_parcelas_pagas' => $row['quantidade_parcelas_pagas'],
                    'cre_id_arquivo' => $dados->cre_id_arquivo,
                ]);
            }else{
                $arquivo = ContratosArquivos::create([
                    'cre_id_produtos' => ContratosProdutos::where('codigo', $row['codigo_produto'])->select('id')->first()->id,
                ]);
                Contratos::create([
                    'num_contrato' => (int) $row['numero_contrato_credito'],
                    'situacao' => $row['situacao_contrato'],
                    'modalidade' => $row['modalidade_produto'],
                    'codigo_modalidade' => $row['codigo_modalidade_produto'],
                    'sigla_modalidade' => $row['sigla_modalidade_produto'],
                    'data_operacao' => gmdate('Y-m-d', (($row['data_operacao_contrato'] - 25569) * 86400)),
                    'data_vencimento' => gmdate('Y-m-d', (($row['data_vencimento_contrato'] - 25569) * 86400)),
                    'data_quitacao' => ($row['situacao_contrato'] == 'QUITADO' ? gmdate('Y-m-d', (($row['data_movimento'] - 25569) * 86400)) : '1900-01-01'),
                    'valor_contrato' => number_format($row['valor_contrato'], 2, '.', ''),
                    'cli_id_associado' => Associados::where('id_sisbr', $row['numero_cliente_sisbr'])->select('id')->first()->id,
                    'finalidade' => $row['finalidade_operacao_credito'],
                    'renegociacao' => $row['indicador_de_repactuacao'],
                    'cod_linha' => $row['codigo_linha_credito'],
                    'linha' => $row['linha_credito'],
                    'taxa_operacao' => number_format($row['taxa_operacao'], 2, '.', ''),
                    'taxa_mora' => number_format($row['taxa_mora'], 2, '.', ''),
                    'taxa_multa' =>  number_format($row['taxa_multa'], 2, '.', ''),
                    'data_movimento' => gmdate('Y-m-d', (($row['data_movimento'] - 25569) * 86400)),
                    'valor_devido' => ($row['situacao_contrato'] == 'QUITADO' ? 0 : number_format($row['valor_saldo_devedor_diario'], 2, '.', '')),
                    'nivel_risco' => $row['nivel_risco_atual'],
                    'qtd_parcelas' => $row['quantidade_parcelas'],
                    'qtd_parcelas_pagas' => $row['quantidade_parcelas_pagas'],
                    'cre_id_arquivo' => $arquivo->id,
                ]);  
            }
        }   
    }

    public function registerEvents(): array
    {
        return [
            AfterImport::class => function(AfterImport $event) {
                Logs::create(['mensagem' => 'Inicilizando importação de cre_contratos.xlsx...']);
                Logs::create(['mensagem' => 'Processando o arquivo cre_contratos.xlsx...']);
                Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de cre_contratos.xlsx efetuada com sucesso!</span>']);
            },
            ImportFailed::class => function(ImportFailed $event) {
                Logs::create(['mensagem' => 'Inicilizando importação de cre_contratos.xlsx...']);
                Logs::create(['mensagem' => 'Processando o arquivo cre_contratos.xlsx...']);
                Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cre_contratos.xlsx!</span>']);
            },
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
