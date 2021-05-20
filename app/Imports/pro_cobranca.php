<?php

namespace App\Imports;

use App\Models\Associados;
use App\Models\ProCobranca;
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

class pro_cobranca implements ToCollection, WithChunkReading, WithHeadingRow, ShouldQueue, WithEvents
{
    use Importable, RegistersEventListeners;

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {   
            ProCobranca::create([
                'situacao' => $row['situacao_contrato_cobranca'], 
                'indicador_contrato' => ($row['indicador_contrato_cobranca'] == 'SIM' ? 1 : 0),  
                'perfil' => $row['perfil_tarifario_cobranca'], 
                'ramo' => $row['ramo_atividade'], 
                'grupo' => $row['grupo_atividade'], 
                'tipo_dda' => $row['tipo_dda'], 
                'data_adesao' => gmdate('Y-m-d', (($row['data_de_adesao'] - 25569) * 86400)),
                'float' => (int) $row['quantidade_dias_float'],
                'data_movimento' => gmdate('Y-m-d', (($row['data_movimento'] - 25569) * 86400)),
                'cli_id_associado' => ($row['numero_cliente_sisbr'] > 0 ? Associados::where('id_sisbr', $row['numero_cliente_sisbr'])->select('id')->first()->id : null),
            ]);
        }
    }

    public function registerEvents(): array
    {
        return [
            BeforeImport::class => function(BeforeImport $event) { 
                ProCobranca::truncate();
            },
            AfterImport::class => function(AfterImport $event) {
                Logs::create(['mensagem' => 'Inicilizando importação de pro_cobranca.xlsx...']);
                Logs::create(['mensagem' => 'Processando o arquivo pro_cobranca.xlsx...']);
                Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de pro_cobranca.xlsx efetuada com sucesso!</span>']);
            },
            ImportFailed::class => function(ImportFailed $event) {
                Logs::create(['mensagem' => 'Inicilizando importação de pro_cobranca.xlsx...']);
                Logs::create(['mensagem' => 'Processando o arquivo pro_cobranca.xlsx...']);
                Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo pro_cobranca.xlsx!</span>']);
            },
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
