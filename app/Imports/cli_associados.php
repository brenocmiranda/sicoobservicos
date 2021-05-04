<?php

namespace App\Imports;

use App\Models\Associados;
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

class cli_associados implements ToCollection, WithChunkReading, WithHeadingRow, ShouldQueue, WithEvents
{
    use Importable, RegistersEventListeners;

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {   
            $dados = Associados::where('id_sisbr', $row['numero_cliente_sisbr'])->first();
            if(isset($dados)){
                Associados::where('id_sisbr', $row['numero_cliente_sisbr'])->update([
                    'nome' => $row['nome_cliente'], 
                    'nome_fantasia' => $row['nome_fantasia'], 
                    'representante' => $row['nome_responsavel_empresa'],
                    'documento' => $row['cpfcnpj'], 
                    'tipo_renda' => $row['tipo_de_renda'], 
                    'renda' => $row['renda_bruta_mensal'], 
                    'cod_cnae' => ($row['codigo_cnae'] > 0 ? $row['codigo_cnae'] : 'NÃO POSSUI'),
                    'data_nascimento' => gmdate('Y-m-d', (($row['data_nascimento'] - 25569) * 86400)), 
                    'atividade_economica' => $row['atividade_economica_do_cliente'], 
                    'sexo' => ($row['sexo'] == 'F' || $row['sexo'] == 'M' ? $row['sexo'] : 'NÃO POSSUI'), 
                    'sigla' => $row['sigla_tipo_pessoa'], 
                    'funcionario' => $row['indicador_funcionario'], 
                    'data_relacionamento' => gmdate('Y-m-d', (($row['data_inicio_relacionamento'] - 25569) * 86400)),
                    'data_renovacao' => gmdate('Y-m-d', (($row['data_ultima_renovacao_cadastral'] - 25569) * 86400)),  
                    'PA' => $row['numero_pa'],
                    'nome_gerente' => $row['nome_do_gerente'],
                    'descricao_identidade' => $row['descricao_documento_identidade'],
                    'numero_identidade' => $row['numero_documento_identidade'],
                    'politicamente_exposta' => $row['indicador_pessoa_politicamente_exposta'],
                    'profissao' => $row['profissao'],
                    'naturalidade' => $row['naturalidade'],
                    'perfil_tarifario' => $row['descricao_do_perfil_tarifario_do_cliente'],
                ]);
            }else{
                Associados::create([
                    'id_sisbr' => (int) $row['numero_cliente_sisbr'], 
                    'nome' => $row['nome_cliente'], 
                    'nome_fantasia' => $row['nome_fantasia'], 
                    'representante' => $row['nome_responsavel_empresa'],
                    'documento' => $row['cpfcnpj'], 
                    'tipo_renda' => $row['tipo_de_renda'], 
                    'renda' => $row['renda_bruta_mensal'], 
                    'cod_cnae' => ($row['codigo_cnae'] > 0 ? $row['codigo_cnae'] : 'NÃO POSSUI'),
                    'data_nascimento' => gmdate('Y-m-d', (($row['data_nascimento'] - 25569) * 86400)), 
                    'atividade_economica' => $row['atividade_economica_do_cliente'], 
                    'sexo' => ($row['sexo'] == 'F' || $row['sexo'] == 'M' ? $row['sexo'] : 'NÃO POSSUI'), 
                    'sigla' => $row['sigla_tipo_pessoa'], 
                    'funcionario' => $row['indicador_funcionario'], 
                    'data_relacionamento' => gmdate('Y-m-d', (($row['data_inicio_relacionamento'] - 25569) * 86400)),
                    'data_renovacao' => gmdate('Y-m-d', (($row['data_ultima_renovacao_cadastral'] - 25569) * 86400)),  
                    'PA' => $row['numero_pa'],
                    'nome_gerente' => $row['nome_do_gerente'],
                    'descricao_identidade' => $row['descricao_documento_identidade'],
                    'numero_identidade' => $row['numero_documento_identidade'],
                    'politicamente_exposta' => $row['indicador_pessoa_politicamente_exposta'],
                    'profissao' => $row['profissao'],
                    'naturalidade' => $row['naturalidade'],
                    'perfil_tarifario' => $row['descricao_do_perfil_tarifario_do_cliente'],
                ]);
            }
        }
    }

    public function registerEvents(): array
    {
        return [
            AfterImport::class => function(AfterImport $event) {
                Logs::create(['mensagem' => 'Inicilizando importação de cli_associados.xlsx...']);
                Logs::create(['mensagem' => 'Processando o arquivo cli_associados.xlsx...']);
                Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de cli_associados.xlsx efetuada com sucesso!</span>']);
            },
            ImportFailed::class => function(ImportFailed $event) {
                Logs::create(['mensagem' => 'Inicilizando importação de cli_associados.xlsx...']);
                Logs::create(['mensagem' => 'Processando o arquivo cli_associados.xlsx...']);
                Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cli_associados.xlsx!</span>']);
            },
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
