<?php

namespace App\Imports;

use App\Models\Associados;
use App\Models\AssociadosConsolidado;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class cli_consolidado implements ToCollection, WithBatchInserts, WithChunkReading, WithHeadingRow
{
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

    public function batchSize(): int
    {
        return 1000;
    }
    
    public function chunkSize(): int
    {
        return 1000;
    }
}
