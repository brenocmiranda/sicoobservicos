<?php

namespace App\Imports;

use App\Models\Contratos;
use App\Models\ContratosParcelas;
use App\Models\Logs;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;

class cre_contratos_parcelas implements ToCollection, WithChunkReading, WithHeadingRow, ShouldQueue, WithEvents
{
    use Importable, RegistersEventListeners;

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {  
            $dados = Contratos::where('num_contrato', $row['numero_contrato_credito'])->first();

            if(isset($dados)){
                ContratosParcelas::create([
                    'num_parcela' => $row['numero_parcela'],
                    'data_vencimento' => gmdate('Y-m-d', (($row['data_vencimento_parcela'] - 25569) * 86400)),
                    'valor_parcela' => number_format($row['valor_parcela'], 2, '.', ''),
                    'valor_pago_parcela' => number_format($row['valor_pago_parcela'], 2, '.', ''),
                    'valor_devedor_parcela' => number_format($row['valor_saldo_devedor_parcela'], 2, '.', ''),
                    'valor_juros_parcela' => number_format($row['valor_juros_parcela'], 2, '.', ''),
                    'dias_atraso' => $row['quantidade_dias_atraso'],
                    'situacao' => $row['situacao_parcela'],
                    'data_movimento' => gmdate('Y-m-d', (($row['data_movimento'] - 25569) * 86400)),
                    'cre_id_contratos' => $dados->id,
                ]);   
            }
        }   
    }

    public function registerEvents(): array
    {
        return [
            BeforeImport::class => function(BeforeImport $event) { 
                ContratosParcelas::truncate();
            },
            AfterImport::class => function(AfterImport $event) {
                Logs::create(['mensagem' => 'Inicilizando importação de cre_contratos_parcelas.xlsx...']);
                Logs::create(['mensagem' => 'Processando o arquivo cre_contratos_parcelas.xlsx...']);
                Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de cre_contratos_parcelas.xlsx efetuada com sucesso!</span>']);
            },
            ImportFailed::class => function(ImportFailed $event) {
                Logs::create(['mensagem' => 'Inicilizando importação de cre_contratos_parcelas.xlsx...']);
                Logs::create(['mensagem' => 'Processando o arquivo cre_contratos_parcelas.xlsx...']);
                Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cre_contratos_parcelas.xlsx!</span>']);
            },
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
