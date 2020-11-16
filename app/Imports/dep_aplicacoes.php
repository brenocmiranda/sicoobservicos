<?php

namespace App\Imports;

use App\Models\Associados;
use App\Models\Aplicacoes;
use App\Models\ContaCorrente;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class dep_aplicacoes implements ToCollection, WithBatchInserts, WithChunkReading, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {   
            $associado = Associados::where('id_sisbr', $row['numero_cliente_sisbr'])->select('id')->first();
            $dados = Aplicacoes::where('num_conta', $row['numero_conta_aplicacao'])->first();
            if(isset($dados)){
                 Aplicacoes::where('num_conta', $row['numero_conta_aplicacao'])->update([
                    'modalidade' => $row['modalidade_captacao'], 
                    'tipo' => $row['tipo_modalidade_captacao'], 
                    'valor_correcao' => number_format($row['valor_correcao_monetaria'], 2, '.', ''),
                    'valor_inicial' => number_format($row['valor_inicial_aplicado'], 2, '.', ''),
                    'valor_saldo' => number_format($row['valor_saldo_diario'], 2, '.', ''),
                    'data_movimento' => gmdate('Y-m-d', (($row['data_movimento'] - 25569) * 86400)),
                    'cco_id_contacorrente' => ContaCorrente::where('num_contrato', $row['numero_conta_corrente'])->select('id')->first()->id
                ]);
            }else{
                Aplicacoes::create([
                    'num_conta' => (int) $row['numero_conta_aplicacao'], 
                    'modalidade' => $row['modalidade_captacao'], 
                    'tipo' => $row['tipo_modalidade_captacao'], 
                    'valor_correcao' => number_format($row['valor_correcao_monetaria'], 2, '.', ''),
                    'valor_inicial' => number_format($row['valor_inicial_aplicado'], 2, '.', ''),
                    'valor_saldo' => number_format($row['valor_saldo_diario'], 2, '.', ''),
                    'data_movimento' => gmdate('Y-m-d', (($row['data_movimento'] - 25569) * 86400)),
                    'cco_id_contacorrente' => ContaCorrente::where('num_contrato', $row['numero_conta_corrente'])->select('id')->first()->id,
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