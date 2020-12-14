<?php

namespace App\Imports;

use App\Models\Associados;
use App\Models\Poupancas;
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

class pop_poupanca implements ToCollection, WithChunkReading, WithHeadingRow, ShouldQueue, WithEvents
{
    use Importable, RegistersEventListeners;

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {   
            $dados = Poupancas::where('num_conta', $row['numero_conta_poupanca'])->first();
            if(isset($dados)){
                 Poupancas::where('num_conta', $row['numero_conta_poupanca'])->update([
                    'situacao' => $row['situacao_da_conta'], 
                    'tipo_conta' => $row['tipo_conta_poupanca'], 
                    'tipo_poupanca' => $row['tipo_poupanca'], 
                    'data_abertura' => gmdate('Y-m-d', (($row['data_abertura_conta_poupanca'] - 25569) * 86400)),
                    'valor_saldo' => number_format($row['valor_saldo_diario'], 2, '.', ''),
                    'data_movimento' => gmdate('Y-m-d', (($row['data_movimento'] - 25569) * 86400))
                ]);
            }else{
                Poupancas::create([
                    'num_conta' => (int) $row['numero_conta_poupanca'], 
                    'situacao' => $row['situacao_da_conta'], 
                    'tipo_conta' => $row['tipo_conta_poupanca'], 
                    'tipo_poupanca' => $row['tipo_poupanca'], 
                    'data_abertura' => gmdate('Y-m-d', (($row['data_abertura_conta_poupanca'] - 25569) * 86400)),
                    'valor_saldo' => number_format($row['valor_saldo_diario'], 2, '.', ''),
                    'data_movimento' => gmdate('Y-m-d', (($row['data_movimento'] - 25569) * 86400)),
                    'cli_id_associado' => Associados::where('id_sisbr', $row['numero_cliente_sisbr'])->select('id')->first()->id,
                ]);
            }
        }
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function(BeforeSheet $event) {
                Logs::create(['mensagem' => 'Inicilizando importação de dep_aplicacoes.xlsx...']);
                Logs::create(['mensagem' => 'Processando o arquivo dep_aplicacoes.xlsx...']);
            },
            AfterImport::class => function(AfterImport $event) {
                Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de pop_poupanca.xlsx efetuada com sucesso!</span>']);
            },
            ImportFailed::class => function(ImportFailed $event) {
               Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo pop_poupanca.xlsx!</span>']);
            },
        ];
    }

    public function chunkSize(): int
    {
        return 50000;
    }
}