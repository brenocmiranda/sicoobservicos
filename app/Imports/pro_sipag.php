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
        	$item = ProSipag::where('ec', $row['estabelecimento_comercial'])->first();
            $associado = Associados::where('documento', $row['cpfcnpj'])->select('id')->first();

        	if(isset($item)){
        		ProSipag::where('ec', $row['estabelecimento_comercial'])->update([
	                'base' => $row['base'], 
	                'mcc' => $row['mcc'], 
	                'descricao_mcc' => $row['descricao_mcc'], 
	                'segmento' => $row['macro_segmento'], 
	                'cnae' => $row['cnae'], 
	                'descricao_cnae' => $row['descricao_cnae'], 
	                'data_credenciamento' => gmdate('Y-m-d', (($row['dt_credenc'] - 25569) * 86400)),
	                'status' => $row['status'], 
	                'ecommerce' => ($row['e_commerce'] == "SIM" ? 1 : 0),
                    'data_movimento' => date('Y-m-d', strtotime('-2 day')),
	                'cli_id_associado' => (isset($associado) ? $associado->id : null),
	            ]);
        	}else{
        		ProSipag::create([
	                'ec' => $row['estabelecimento_comercial'], 
	                'base' => $row['base'], 
	                'mcc' => $row['mcc'], 
	                'descricao_mcc' => $row['descricao_mcc'], 
	                'segmento' => $row['macro_segmento'], 
	                'cnae' => $row['cnae'], 
	                'descricao_cnae' => $row['descricao_cnae'], 
	                'data_credenciamento' => gmdate('Y-m-d', (($row['dt_credenc'] - 25569) * 86400)),
	                'status' => $row['status'], 
	                'ecommerce' => ($row['e_commerce'] == "SIM" ? 1 : 0),
                    'data_movimento' => date('Y-m-d', strtotime('-2 day')),
                    'cli_id_associado' => (isset($associado) ? $associado->id : null),
	            ]);
        	}
            
        }
    }

    public function registerEvents(): array
    {
        return [
            AfterImport::class => function(AfterImport $event) {
                Logs::create(['mensagem' => 'Inicilizando importação de pro_seguros.xlsx...']);
                Logs::create(['mensagem' => 'Processando o arquivo pro_seguros.xlsx...']);
                Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de pro_seguros.xlsx efetuada com sucesso!</span>']);
            },
            ImportFailed::class => function(ImportFailed $event) {
                Logs::create(['mensagem' => 'Inicilizando importação de pro_seguros.xlsx...']);
                Logs::create(['mensagem' => 'Processando o arquivo pro_seguros.xlsx...']);
                Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo pro_seguros.xlsx!</span>']);
            },
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
