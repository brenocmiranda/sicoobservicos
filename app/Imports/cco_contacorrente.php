<?php

namespace App\Imports;

use App\Models\ContaCorrente;
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

class cco_contacorrente implements ToCollection, WithChunkReading, WithHeadingRow, ShouldQueue, WithEvents
{   
    use Importable, RegistersEventListeners;

    public function collection(Collection $rows)
    {   
        foreach ($rows as $row) 
        {  
            $dados = ContaCorrente::where('num_contrato', $row['numero_conta_corrente'])->first();
            if(isset($dados)){      
                ContratosArquivos::find($dados->cre_id_arquivo)->update([
                    'cre_id_produtos' => ContratosProdutos::where('codigo', 3)->select('id')->first()->id,
                ]);       
                ContaCorrente::where('num_contrato', $row['numero_conta_corrente'])->update([
                    'situacao' => $row['situacao_conta_corrente'],
                    'modalidade_conta' => $row['modalidade_conta_corrente'],
                    'tipo_conta' => $row['tipo_conta_corrente'],
                    'categoria_conta' => $row['categoria_conta_corrente'],
                    'taxa_limite' => number_format($row['taxa_limite_credito'], 2, '.', ''),
                    'utilizacao_limite' => $row['quantidade_dias_utilizacao_limite_credito'],
                    'valor_contratado' => number_format($row['valor_limite_credito_contratato'], 2, '.', ''),
                    'valor_utilizado' => number_format($row['valor_saldo_devedor_limite_credito'], 2, '.', ''),
                    'taxa_adp' => number_format($row['taxa_adp'], 2, '.', ''),
                    'utilizacao_adp' => $row['quantidade_dias_utilizacao_adp'],
                    'valor_adp' => number_format($row['valor_saldo_devedor_adp'], 2, '.', ''),
                    'sem_movimentacao' => $row['dias_sem_movimentacao'],
                    'ultima_movimentacao' =>  gmdate('Y-m-d', (($row['data_utimo_movimento_conta_corrente'] - 25569) * 86400)),
                    'valor_saldo' => number_format($row['valor_saldo_deposito_conta_corrente'], 2, '.', ''),
                    'valor_pacote' => number_format($row['valor_pacote_tarifario'], 2, '.', ''),
                    'data_abertura' => gmdate('Y-m-d', (($row['data_abertura_conta_corrente'] - 25569) * 86400)),
                    'data_encerramento' => gmdate('Y-m-d', (($row['data_encerramento_conta_corrente'] - 25569) * 86400)),
                    'data_movimento' => gmdate('Y-m-d', (($row['data_movimento'] - 25569) * 86400)),
                    'cre_id_arquivo' => $dados->cre_id_arquivo,
                ]); 
            }else{
                $arquivo = ContratosArquivos::create([
                    'cre_id_produtos' => ContratosProdutos::where('codigo', 3)->select('id')->first()->id,
                ]);
                ContaCorrente::create([
                    'num_contrato' => (int) $row['numero_conta_corrente'],
                    'situacao' => $row['situacao_conta_corrente'],
                    'modalidade_conta' => $row['modalidade_conta_corrente'],
                    'tipo_conta' => $row['tipo_conta_corrente'],
                    'categoria_conta' => $row['categoria_conta_corrente'],
                    'taxa_limite' => number_format($row['taxa_limite_credito'], 2, '.', ''),
                    'utilizacao_limite' => $row['quantidade_dias_utilizacao_limite_credito'],
                    'valor_contratado' => number_format($row['valor_limite_credito_contratato'], 2, '.', ''),
                    'valor_utilizado' => number_format($row['valor_saldo_devedor_limite_credito'], 2, '.', ''),
                    'taxa_adp' => number_format($row['taxa_adp'], 2, '.', ''),
                    'utilizacao_adp' => $row['quantidade_dias_utilizacao_adp'],
                    'valor_adp' => number_format($row['valor_saldo_devedor_adp'], 2, '.', ''),
                    'sem_movimentacao' => $row['dias_sem_movimentacao'],
                    'ultima_movimentacao' =>  gmdate('Y-m-d', (($row['data_utimo_movimento_conta_corrente'] - 25569) * 86400)),
                    'valor_saldo' => number_format($row['valor_saldo_deposito_conta_corrente'], 2, '.', ''),
                    'valor_pacote' => number_format($row['valor_pacote_tarifario'], 2, '.', ''),
                    'data_abertura' => gmdate('Y-m-d', (($row['data_abertura_conta_corrente'] - 25569) * 86400)),
                    'data_encerramento' => gmdate('Y-m-d', (($row['data_encerramento_conta_corrente'] - 25569) * 86400)),
                    'data_movimento' => gmdate('Y-m-d', (($row['data_movimento'] - 25569) * 86400)),
                    'cre_id_arquivo' => $arquivo->id,
                    'cli_id_associado' => Associados::where('id_sisbr', $row['numero_cliente_sisbr'])->select('id')->first()->id,
                ]); 
            }
        }   
    }

    public function registerEvents(): array
    {
        return [
            AfterImport::class => function(AfterImport $event) {
                Logs::create(['mensagem' => 'Inicilizando importação de cco_contacorrente.xlsx.']);
                Logs::create(['mensagem' => 'Processando o arquivo cco_contacorrente.xlsx...']);
                Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de cco_contacorrente.xlsx efetuada com sucesso!</span>']);
            },
            ImportFailed::class => function(ImportFailed $event) {
                Logs::create(['mensagem' => 'Inicilizando importação de cco_contacorrente.xlsx.']);
                Logs::create(['mensagem' => 'Processando o arquivo cco_contacorrente.xlsx...']);
                Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cco_contacorrente.xlsx!</span>']);
            },
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
