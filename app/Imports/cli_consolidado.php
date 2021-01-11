<?php

namespace App\Imports;

use App\Models\Associados;
use App\Models\AssociadosConsolidado;
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

class cli_consolidado implements ToCollection, WithChunkReading, WithHeadingRow, ShouldQueue, WithEvents
{
    use Importable, RegistersEventListeners;

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {  
            $associado = Associados::where('id_sisbr', $row['numero_cliente_sisbr'])->select('id')->first();
            $dados = AssociadosConsolidado::where('cli_id_associado', $associado->id)->first();
            if(isset($dados)){
                AssociadosConsolidado::where('cli_id_associado', $associado->id)->update([
                    'nivel_risco' => $row['nivel_risco_cliente'],
                    'nivel_risco_crl' => $row['nivel_risco_limite_crl'],
                    'data_crl' => gmdate('Y-m-d', (($row['data_vigencia_limite_crlcls'] - 25569) * 86400)), 
                    'porte_cliente' => $row['descricao_porte_cliente'],
                    'indicador_rural' => $row['indicador_produto_rural'],
                    'categoria_rural' => $row['descricao_categoria_produtor_rural'],
                    'escolaridade' => $row['escolaridade'],
                    'estado_civil' => $row['estado_civil'],
                    'valor_imovel' => number_format($row['valor_bem_imovel'], 2, '.', ''),
                    'valor_movel' => number_format($row['valor_bem_movel'], 2, '.', ''),
                    'data_movimento' => gmdate('Y-m-d', (($row['data_movimento'] - 25569) * 86400)),
                ]); 
            }else{
                AssociadosConsolidado::create([
                    'nivel_risco' => $row['nivel_risco_cliente'],
                    'nivel_risco_crl' => $row['nivel_risco_limite_crl'],
                    'data_crl' => gmdate('Y-m-d', (($row['data_vigencia_limite_crlcls'] - 25569) * 86400)), 
                    'porte_cliente' => $row['descricao_porte_cliente'],
                    'indicador_rural' => $row['indicador_produto_rural'],
                    'categoria_rural' => $row['descricao_categoria_produtor_rural'],
                    'escolaridade' => $row['escolaridade'],
                    'estado_civil' => $row['estado_civil'],
                    'valor_imovel' => number_format($row['valor_bem_imovel'], 2, '.', ''),
                    'valor_movel' => number_format($row['valor_bem_movel'], 2, '.', ''),
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
                Logs::create(['mensagem' => 'Inicilizando importação de cli_consolidado.xlsx...']);
                Logs::create(['mensagem' => 'Processando o arquivo cli_consolidado.xlsx...']);
                Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de cli_consolidado.xlsx efetuada com sucesso!</span>']);
            },
            ImportFailed::class => function(ImportFailed $event) {
                Logs::create(['mensagem' => 'Inicilizando importação de cli_consolidado.xlsx...']);
                Logs::create(['mensagem' => 'Processando o arquivo cli_consolidado.xlsx...']);
                Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cli_consolidado.xlsx!</span>']);
            },
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}

