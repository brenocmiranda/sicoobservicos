<?php

namespace App\Imports;

use App\Models\Associados;
use App\Models\Poupancas;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class pop_poupanca implements ToCollection, WithBatchInserts, WithChunkReading, WithHeadingRow
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
            $dados = Poupancas::where('cli_id_associado', $associado->id)->first();
            if(isset($dados)){
                 Poupancas::where('cli_id_associado', $associado->id)->update([
                    'num_conta' => (int) $row['numero_conta_poupanca'], 
                    'situacao' => $row['situacao_da_conta'], 
                    'tipo_conta' => $row['tipo_conta_poupanca'], 
                    'tipo_poupanca' => $row['tipo_poupanca'], 
                    'data_abertura' => gmdate('Y-m-d', (($row['data_abertura_conta_poupanca'] - 25569) * 86400)),
                    'valor_saldo' => number_format($row['valor_saldo_diario'], 2, '.', ''),
                    'data_movimento' => gmdate('Y-m-d', (($row['data_movimento'] - 25569) * 86400))
                ]);
            }else{
                Poupancas::create([
                    'num_conta' => (int) $row['numero_conta_poupanca'], 
                    'situacao' => $row['situacao_da_conta'], 
                    'tipo_conta' => $row['tipo_conta_poupanca'], 
                    'tipo_poupanca' => $row['tipo_poupanca'], 
                    'data_abertura' => gmdate('Y-m-d', (($row['data_abertura_conta_poupanca'] - 25569) * 86400)),
                    'valor_saldo' => number_format($row['valor_saldo_diario'], 2, '.', ''),
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