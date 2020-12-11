<?php

namespace App\Imports;

use App\Models\Contratos;
use App\Models\Associados;
use App\Models\Garantias;
use App\Models\Logs;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;

class cre_garantias implements ToCollection, WithChunkReading, WithHeadingRow, ShouldQueue, WithEvents
{
    use RegistersEventListeners;

    public function collection(Collection $rows)
    {
    	Logs::create(['mensagem' => 'Inicilizando importação de cre_garantias.xlsx...']);
        Logs::create(['mensagem' => 'Processando o arquivo cre_garantias.xlsx...']);
        Garantias::truncate();
        foreach ($rows as $row) 
	    {  
            Garantias::create([
                'tipo' => $row['tipo_garantia_enquadramento'],
                'descricao' => $row['garantia_enquadramento'],
                'cre_id_arquivo' => Contratos::where('num_contrato', $row['numero_contrato_credito'])->select('cre_id_arquivo')->first()->cre_id_arquivo,
                'data_movimento' => gmdate('Y-m-d', (($row['data_movimento'] - 25569) * 86400)),
            ]);  
	    }
    }

    public function registerEvents(): array
    {
        return [
            AfterImport::class => function(AfterImport $event) {
                Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de cre_garantias.xlsx efetuada com sucesso!</span>']);
            },
            ImportFailed::class => function(ImportFailed $event) {
               Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cre_garantias.xlsx!</span>']);
            },
        ];
    }

    public function chunkSize(): int
    {
        return 50000;
    }
}
