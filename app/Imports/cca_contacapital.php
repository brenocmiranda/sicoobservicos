<?php

namespace App\Imports;

use App\Models\ContaCapital;
use App\Models\Associados;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class cca_contacapital implements ToCollection, WithBatchInserts, WithChunkReading, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {  
            $associado = Associados::where('id_sisbr', $row['numero_cliente_sisbr'])->select('id')->first();
            $dados = ContaCapital::where('num_capital', $row['numero_conta_capital'])->first();
            if(isset($dados)){
                ContaCapital::where('num_capital', $row['numero_conta_capital'])->update([
                    'situacao_capital' => $row['situacao_conta_capital'],
                    'direito_voto' => $row['indicador_associado_direito_voto'],
                    'direito_rateio' => $row['indicador_associado_direito_rateio'],
                    'data_matricula' => gmdate('Y-m-d', (($row['data_matricula'] - 25569) * 86400)),
                    'saida_matricula' => gmdate('Y-m-d', (($row['data_saida_matricula'] - 25569) * 86400)),
                    'valor_integralizado' => number_format($row['valor_saldo_final_integralizado_diario'], 2, '.', ''),
                    'data_movimento' => gmdate('Y-m-d', (($row['data_movimento'] - 25569) * 86400)),
                ]); 
            }else{
                ContaCapital::create([
                    'num_capital' => $row['numero_conta_capital'],
                    'situacao_capital' => $row['situacao_conta_capital'],
                    'direito_voto' => $row['indicador_associado_direito_voto'],
                    'direito_rateio' => $row['indicador_associado_direito_rateio'],
                    'data_matricula' => gmdate('Y-m-d', (($row['data_matricula'] - 25569) * 86400)),
                    'saida_matricula' => gmdate('Y-m-d', (($row['data_saida_matricula'] - 25569) * 86400)),
                    'valor_integralizado' => number_format($row['valor_saldo_final_integralizado_diario'], 2, '.', ''),
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
