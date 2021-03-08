<?php

namespace App\Imports;

use App\Models\Associados;
use App\Models\ProSeguros;
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

class pro_seguros implements ToCollection, WithChunkReading, WithHeadingRow, ShouldQueue, WithEvents
{
    use Importable, RegistersEventListeners;

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {   
            $dados = ProSeguros::where('n_proposta', $row['numero_proposta_seguro'])->first();
            if(isset($dados)){
                 ProSeguros::where('n_proposta', $row['numero_proposta_seguro'])->update([
                    'documento' => $row['numero_cpfcnpj'], 
                    'nome_associado' => $row['nome_razao_social'], 
                    'n_proposta' => $row['numero_proposta_seguro'], 
                    'n_apolice' => $row['numero_apolice_certificado_seguro'], 
                    'corretora' => $row['nome_corretora'], 
                    'seguradora' => $row['nome_seguradora'], 
                    'ramo' => $row['descricao_ramo_produto'], 
                    'familia' => $row['descricao_familia_produto'], 
                    'premio_bruto' => number_format($row['valor_premio_bruto'], 2, '.', ''), 
                    'premio_liquido' => number_format($row['valor_premio_liquido'], 2, '.', ''),
                    'comissao' => number_format($row['valor_comissao_prevista'], 2, '.', ''),
                    'data_vigencia' => gmdate('Y-m-d', (($row['data_inicio_vigencia_apolice'] - 25569) * 86400)), 
                    'data_encerramento' => gmdate('Y-m-d', (($row['data_fim_vigencia_apolice'] - 25569) * 86400)), 
                    'cpf_atendente' => $row['numero_cpf_atendente'], 
                    'data_movimento' => gmdate('Y-m-d', (($row['data_movimento'] - 25569) * 86400)),
                ]);
            }else{
                ProSeguros::create([
                    'documento' => $row['numero_cpfcnpj'], 
                    'nome_associado' => $row['nome_razao_social'], 
                    'n_proposta' => $row['numero_proposta_seguro'], 
                    'n_apolice' => $row['numero_apolice_certificado_seguro'], 
                    'corretora' => $row['nome_corretora'], 
                    'seguradora' => $row['nome_seguradora'], 
                    'ramo' => $row['descricao_ramo_produto'], 
                    'familia' => $row['descricao_familia_produto'], 
                    'premio_bruto' => number_format($row['valor_premio_bruto'], 2, '.', ''), 
                    'premio_liquido' => number_format($row['valor_premio_liquido'], 2, '.', ''),
                    'comissao' => number_format($row['valor_comissao_prevista'], 2, '.', ''),
                    'data_vigencia' => gmdate('Y-m-d', (($row['data_inicio_vigencia_apolice'] - 25569) * 86400)), 
                    'data_encerramento' => gmdate('Y-m-d', (($row['data_fim_vigencia_apolice'] - 25569) * 86400)), 
                    'cpf_atendente' => $row['numero_cpf_atendente'], 
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
