<?php

namespace App\Imports;

use App\Models\Associados;
use App\Models\ProSipag;
use App\Models\ProSipagFaturamento;
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

class pro_sipag_faturamento implements ToCollection, WithChunkReading, WithHeadingRow, ShouldQueue, WithEvents
{
    use Importable, RegistersEventListeners;

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {   
            $item = ProSipag::where('ec', $row['ec'])->first();
            $data = ProSipagFaturamento::where('data_movimento', $row['data'])->first();

            if(!isset($data)){
                ProSipag::find($item->id)->update([
                    'descricao_mcc' => $row['descricao_mcc'], 
                    'segmento' => $row['macro_segmento'],
                ]);
                ProSipagFaturamento::create([
                    'total_cnpj' => $row['total_cnpj'],
                    'total_master' => $row['total_master'],
                    'total_visa' => $row['total_visa'],
                    'total_cabal' => $row['total_cabal'],
                    'total_credito' => $row['total_credito'],
                    'total_debito' => $row['total_debito'],
                    'total_2_a_6' => $row['total_2_a_6'],
                    'total_7_a_12' => $row['total_7_a_12'],
                    'total_soma_outros' => $row['soma_outros'],
                    'data_movimento' => gmdate('Y-m-d', (($row['data'] - 25569) * 86400)),
                    'pro_id_sipag' => (isset($item) ? $item->id : null),
                ]);
            }else{
                ProSipag::find($item->id)->update([
                    'descricao_mcc' => $row['descricao_mcc'], 
                    'segmento' => $row['macro_segmento'],
                ]);
                ProSipagFaturamento::where('ec', $row['ec'])->where('data_movimento', $row['data'])->update([
                    'total_cnpj' => $row['total_cnpj'],
                    'total_master' => $row['total_master'],
                    'total_visa' => $row['total_visa'],
                    'total_cabal' => $row['total_cabal'],
                    'total_credito' => $row['total_credito'],
                    'total_debito' => $row['total_debito'],
                    'total_2_a_6' => $row['total_2_a_6'],
                    'total_7_a_12' => $row['total_7_a_12'],
                    'total_soma_outros' => $row['soma_outros'],
                    'data_movimento' => gmdate('Y-m-d', (($row['data'] - 25569) * 86400)),
                    'pro_id_sipag' => (isset($item) ? $item->id : null),
                ]);

            }
        }
    }

    public function registerEvents(): array
    {
        return [
            AfterImport::class => function(AfterImport $event) {
                Logs::create(['mensagem' => 'Inicilizando importação de pro_sipag_faturamento.xlsx...']);
                Logs::create(['mensagem' => 'Processando o arquivo pro_sipag_faturamento.xlsx...']);
                Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de pro_sipag_faturamento.xlsx efetuada com sucesso!</span>']);
            },
            ImportFailed::class => function(ImportFailed $event) {
                Logs::create(['mensagem' => 'Inicilizando importação de pro_sipag_faturamento.xlsx...']);
                Logs::create(['mensagem' => 'Processando o arquivo pro_sipag_faturamento.xlsx...']);
                Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo pro_sipag_faturamento.xlsx!</span>']);
            },
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
