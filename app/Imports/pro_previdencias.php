<?php

namespace App\Imports;

use App\Models\Associados;
use App\Models\ProPrevidencias;
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

class pro_previdencias implements ToCollection, WithChunkReading, WithHeadingRow, ShouldQueue, WithEvents
{
    use Importable, RegistersEventListeners;

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {   
            ProPrevidencias::create([
                'documento' => $row['numero_cpf_proposta'], 
                'n_registro' => $row['numero_registro'], 
                'aposentadoria' => $row['descricao_possibilidade_aposentadoria'], 
                'autopatrocionio' => $row['descricao_possibilidade_auto_patrocinio'], 
                'resgate' => $row['descricao_participante_em_possibilidade_de_solicitacao_de_resgate'], 
                'beneficioproporiconal' => $row['descricao_possibilidade_de_beneficio_proporcional_diferido'], 
                'data_adesao' => gmdate('Y-m-d', (($row['data_adesao'] - 25569) * 86400)),
                'data_desligamento' => gmdate('Y-m-d', (($row['data_desligamento'] - 25569) * 86400)),
                'situacao_participante' => $row['descricao_situacao_participante'], 
                'tipo_participante' => $row['descricao_tipo_participante'], 
                'forma_pagamento' => $row['descricao_forma_pagamento'], 
                'plano' => $row['descricao_tipo_plano'], 
                'regime' => $row['descricao_tipo_regime_tributcao'], 
                'peculio_morte' => number_format($row['valor_peculio_morte'], 2, '.', ''),  
                'peculio_invalidez' => number_format($row['valor_peculio_invalidez'], 2, '.', ''),  
                'valor_proposta' => number_format($row['valor_proposta'], 2, '.', ''), 
                'data_movimento' => gmdate('Y-m-d', (($row['data_movimento'] - 25569) * 86400)),    
                'cli_id_associado' => ($row['numero_cliente_sisbr'] > 0 ? Associados::where('id_sisbr', $row['numero_cliente_sisbr'])->select('id')->first()->id : null),
            ]);
        }
    }

    public function registerEvents(): array
    {
        return [
            BeforeImport::class => function(BeforeImport $event) { 
                 ProPrevidencias::truncate();
            },
            AfterImport::class => function(AfterImport $event) {
                Logs::create(['mensagem' => 'Inicilizando importação de pro_previdencias.xlsx...']);
                Logs::create(['mensagem' => 'Processando o arquivo pro_previdencias.xlsx...']);
                Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de pro_previdencias.xlsx efetuada com sucesso!</span>']);
            },
            ImportFailed::class => function(ImportFailed $event) {
                Logs::create(['mensagem' => 'Inicilizando importação de pro_previdencias.xlsx...']);
                Logs::create(['mensagem' => 'Processando o arquivo pro_previdencias.xlsx...']);
                Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo pro_previdencias.xlsx!</span>']);
            },
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
