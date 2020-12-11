<?php

namespace App\Imports;

use App\Models\Associados;
use App\Models\ContaCapital;
use App\Models\Logs;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;

class cca_contacapital implements ToCollection, WithChunkReading, WithHeadingRow, ShouldQueue, WithEvents
{
    use RegistersEventListeners;

    public function collection(Collection $rows)
    {
        Logs::create(['mensagem' => 'Inicilizando importação de cca_contacapital.xlsx...']);
        Logs::create(['mensagem' => 'Processando o arquivo cca_contacapital.xlsx...']);
        foreach ($rows as $row) 
        {  
            $dados = ContaCapital::where('num_capital', $row['numero_conta_capital'])->first();
            if(isset($dados)){
                ContaCapital::where('num_capital', $row['numero_conta_capital'])->update([
                    'situacao_capital' => $row['situacao_conta_capital'],
                    'direito_voto' => $row['indicador_associado_direito_voto'],
                    'direito_rateio' => $row['indicador_associado_direito_rateio'],
                    'data_matricula' => gmdate('Y-m-d', (($row['data_matricula'] - 25569) * 86400)),
                    'saida_matricula' => gmdate('Y-m-d', (($row['data_saida_matricula'] - 25569) * 86400)),
                    'valor_integralizado' => number_format($row['valor_saldo_final_integralizado_diario'], 2, '.', ''),
                    'data_movimento' => gmdate('Y-m-d', (($row['data_movimento'] - 25569) * 86400)),
                ]); 
            }else{
                ContaCapital::create([
                    'num_capital' => $row['numero_conta_capital'],
                    'situacao_capital' => $row['situacao_conta_capital'],
                    'direito_voto' => $row['indicador_associado_direito_voto'],
                    'direito_rateio' => $row['indicador_associado_direito_rateio'],
                    'data_matricula' => gmdate('Y-m-d', (($row['data_matricula'] - 25569) * 86400)),
                    'saida_matricula' => gmdate('Y-m-d', (($row['data_saida_matricula'] - 25569) * 86400)),
                    'valor_integralizado' => number_format($row['valor_saldo_final_integralizado_diario'], 2, '.', ''),
                    'data_movimento' => gmdate('Y-m-d', (($row['data_movimento'] - 25569) * 86400)),
                    'cli_id_associado' => Associados::where('id_sisbr', $row['numero_cliente_sisbr'])->select('id')->first()->id,
                ]); 
            }
        }   
    }

    public function registerEvents(): array
    {
        return [
            AfterImport::class => function(AfterImport $event) {
                Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de cca_contacapital.xlsx efetuada com sucesso!</span>']);
            },
            ImportFailed::class => function(ImportFailed $event) {
               Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cca_contacapital.xlsx!</span>']);
            },
        ];
    }

    public function chunkSize(): int
    {
        return 50000;
    }
}
