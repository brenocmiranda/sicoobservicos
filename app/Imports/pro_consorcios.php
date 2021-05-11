<?php

namespace App\Imports;

use App\Models\Associados;
use App\Models\ProConsorcios;
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

class pro_consorcios implements ToCollection, WithChunkReading, WithHeadingRow, ShouldQueue, WithEvents
{

    use Importable, RegistersEventListeners;

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {   
            ProConsorcios::create([
                'n_contrato' => $row['numero_contrato'], 
                'grupo' => $row['codigo_grupo_consorcio'], 
                'cota' => $row['numero_cota'], 
                'versao' => $row['versao_cota'], 
                'situacao' => $row['situacao_cota'], 
                'taxa_administracao' => number_format($row['percentual_taxa_administracao'], 2, '.', ''), 
                'prazo' => $row['prazo_cota'], 
                'parcelas_pagas' => $row['quantidade_parcela_paga'], 
                'segmento' => $row['segmento_consorcio'], 
                'tipo_contemplacao' => $row['tipo_contemplacao'], 
                'prazo_pagamento' => $row['prazo_pagamento_grupo_consorcio'], 
                'forma_pagamento' => $row['forma_pagamento'], 
                'bem_referencia' => $row['bem_referencia'], 
                'data_adesao' => gmdate('Y-m-d', (($row['data_adesao'] - 25569) * 86400)),
                'data_cancelamento' => gmdate('Y-m-d', (($row['data_cancelamento_cota'] - 25569) * 86400)),
                'valor_contratado' => number_format($row['valor_contratado'], 2, '.', ''),
                'data_movimento' => gmdate('Y-m-d', (($row['data_movimento'] - 25569) * 86400)),
                'cli_id_associado' => Associados::where('id_sisbr', $row['numero_cliente_sisbr'])->select('id')->first()->id,
            ]);
        }
    }

    public function registerEvents(): array
    {
        return [
            BeforeImport::class => function(BeforeImport $event) { 
                 ProConsorcios::truncate();
            },
            AfterImport::class => function(AfterImport $event) {
                Logs::create(['mensagem' => 'Inicilizando importação de pro_consorcios.xlsx...']);
                Logs::create(['mensagem' => 'Processando o arquivo pro_consorcios.xlsx...']);
                Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de pro_consorcios.xlsx efetuada com sucesso!</span>']);
            },
            ImportFailed::class => function(ImportFailed $event) {
                Logs::create(['mensagem' => 'Inicilizando importação de pro_consorcios.xlsx...']);
                Logs::create(['mensagem' => 'Processando o arquivo pro_consorcios.xlsx...']);
                Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo pro_consorcios.xlsx!</span>']);
            },
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
