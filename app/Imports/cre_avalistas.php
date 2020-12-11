<?php

namespace App\Imports;

use App\Models\Contratos;
use App\Models\Associados;
use App\Models\Avalistas;
use App\Models\Logs;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;

class cre_avalistas implements ToCollection, WithChunkReading, WithHeadingRow, ShouldQueue, WithEvents
{
    use RegistersEventListeners;

    public function collection(Collection $rows)
    {   
        Logs::create(['mensagem' => 'Inicilizando importação de cre_avalistas.xlsx...']);
        Logs::create(['mensagem' => 'Processando o arquivo cre_avalistas.xlsx...']);
        Avalistas::truncate();
        foreach ($rows as $row) 
        {  
            Avalistas::create([
                'cli_id_associado' => Associados::where('documento', $row['cpf_garantidor_credito'])->select('id')->first()->id,
                'cre_id_arquivo' => Contratos::where('num_contrato', $row['numero_contrato_credito'])->select('cre_id_arquivo')->first()->cre_id_arquivo,
                'data_movimento' => gmdate('Y-m-d', (($row['data_movimento'] - 25569) * 86400)),
            ]);  
        }
    }

    public function registerEvents(): array
    {
        return [
            AfterImport::class => function(AfterImport $event) {
                Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de cre_avalistas.xlsx efetuada com sucesso!</span>']);
            },
            ImportFailed::class => function(ImportFailed $event) {
               Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cre_avalistas.xlsx!</span>']);
            },
        ];
    }

    public function chunkSize(): int
    {
        return 50000;
    }
}
