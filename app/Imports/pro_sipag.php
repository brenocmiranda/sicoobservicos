<?php

namespace App\Imports;

use App\Models\Associados;
use App\Models\ProSipag;
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

class pro_sipag implements ToCollection, WithChunkReading, WithHeadingRow, ShouldQueue, WithEvents
{
    use Importable, RegistersEventListeners;

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {   
        	$item = ProSipag::where('ec', $row['numero_ec'])->first();
            $associado = Associados::where('documento', $row['cpfcnpj'])->select('id')->first();

        	if(isset($item)){
        		ProSipag::where('ec', $row['numero_ec'])->update([
                    'data_credenciamento' => gmdate('Y-m-d', (($row['data_credenciamento'] - 25569) * 86400)),
                    'domicilio_banco' => (isset($row['banco']) ? $row['banco'] : null), 
                    'domicilio_agencia' => (isset($row['agencia']) ? $row['agencia'] : null),
                    'base' => $row['base'],
                    'status' => $row['status'], 
                    'cli_id_associado' => (isset($associado) ? $associado->id : null),
	            ]);
        	}else{
        		ProSipag::create([
	                'ec' => (int) $row['numero_ec'], 
                    'data_credenciamento' => gmdate('Y-m-d', (($row['data_credenciamento'] - 25569) * 86400)),
                    'domicilio_banco' => (isset($row['banco']) ? $row['banco'] : null), 
                    'domicilio_agencia' => (isset($row['agencia']) ? $row['agencia'] : null),
	                'base' => $row['base'],
                    'status' => $row['status'], 
                    'cli_id_associado' => (isset($associado) ? $associado->id : null),
	            ]);
        	}
        }
    }

    public function registerEvents(): array
    {
        return [
            AfterImport::class => function(AfterImport $event) {
                Logs::create(['mensagem' => 'Inicilizando importação de pro_sipag.xlsx...']);
                Logs::create(['mensagem' => 'Processando o arquivo pro_sipag.xlsx...']);
                Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de pro_sipag.xlsx efetuada com sucesso!</span>']);
            },
            ImportFailed::class => function(ImportFailed $event) {
                Logs::create(['mensagem' => 'Inicilizando importação de pro_sipag.xlsx...']);
                Logs::create(['mensagem' => 'Processando o arquivo pro_sipag.xlsx...']);
                Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo pro_sipag.xlsx!</span>']);
            },
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
