<?php

namespace App\Imports;

use App\Models\Associados;
use App\Models\Aplicacoes;
use App\Models\ContaCorrente;
use App\Models\Logs;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;

class dep_aplicacoes implements ToCollection, WithChunkReading, WithHeadingRow, ShouldQueue, WithEvents
{
    use Importable, RegistersEventListeners;

    public function collection(Collection $rows)
    {   
        foreach ($rows as $row) 
        {   
            $dados = Aplicacoes::where('num_conta', $row['numero_conta_aplicacao'])->first();
            if(isset($dados)){
                 Aplicacoes::where('num_conta', $row['numero_conta_aplicacao'])->update([
                    'modalidade' => $row['modalidade_captacao'], 
                    'tipo' => $row['tipo_modalidade_captacao'], 
                    'valor_correcao' => number_format($row['valor_correcao_monetaria'], 2, '.', ''),
                    'valor_inicial' => number_format($row['valor_inicial_aplicado'], 2, '.', ''),
                    'valor_saldo' => number_format($row['valor_saldo_diario'], 2, '.', ''),
                    'data_movimento' => gmdate('Y-m-d', (($row['data_movimento'] - 25569) * 86400)),
                    'cco_id_contacorrente' => ContaCorrente::where('num_contrato', $row['numero_conta_corrente'])->select('id')->first()->id
                ]);
            }else{
                Aplicacoes::create([
                    'num_conta' => (int) $row['numero_conta_aplicacao'], 
                    'modalidade' => $row['modalidade_captacao'], 
                    'tipo' => $row['tipo_modalidade_captacao'], 
                    'valor_correcao' => number_format($row['valor_correcao_monetaria'], 2, '.', ''),
                    'valor_inicial' => number_format($row['valor_inicial_aplicado'], 2, '.', ''),
                    'valor_saldo' => number_format($row['valor_saldo_diario'], 2, '.', ''),
                    'data_movimento' => gmdate('Y-m-d', (($row['data_movimento'] - 25569) * 86400)),
                    'cco_id_contacorrente' => ContaCorrente::where('num_contrato', $row['numero_conta_corrente'])->select('id')->first()->id,
                    'cli_id_associado' => Associados::where('id_sisbr', $row['numero_cliente_sisbr'])->select('id')->first()->id,
                ]);
            }
        }
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function(BeforeSheet $event) {
                Logs::create(['mensagem' => 'Inicilizando importação de pop_poupanca.xlsx...']);
                Logs::create(['mensagem' => 'Processando o arquivo pop_poupanca.xlsx...']);
            },
            AfterImport::class => function(AfterImport $event) {
                Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de dep_aplicacoes.xlsx efetuada com sucesso!</span>']);
            },
            ImportFailed::class => function(ImportFailed $event) {
                Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo dep_aplicacoes.xlsx!</span>']);
            },
        ];
    }

    public function chunkSize(): int
    {
        return 50000;
    }
}