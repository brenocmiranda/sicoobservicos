<?php

namespace App\Imports;

use App\Models\Associados;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AssociadosImport implements ToModel, WithBatchInserts, WithChunkReading, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Associados([
            'id_sisbr' => $row['numero_cliente_sisbr'], 
            'nome' => $row['nome_cliente'], 
            'nome_fantasia' => $row['nome_fantasia'], 
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
            'PA' => $row['numero_pa']
        ]);
    }

    public function batchSize(): int
    {
        return 1000;
    }
    
    public function chunkSize(): int
    {
        return 1000;
    }
}
