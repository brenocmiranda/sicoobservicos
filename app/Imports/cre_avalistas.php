<?php

namespace App\Imports;

use App\Models\Contratos;
use App\Models\Associados;
use App\Models\Avalistas;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class cre_avalistas implements ToCollection, WithBatchInserts, WithChunkReading, WithHeadingRow
{
    public function collection(Collection $rows)
    {   
        foreach ($rows as $row) 
        {  
            $dados = Avalistas::where('codigo', $row['codigo'])->first();
            if(isset($dados)){
                Avalistas::where('codigo', $dados->codigo)->update([
                    'cli_id_associado' => Associados::where('documento', $row['cpf_garantidor_credito'])->select('id')->first()->id,
                    'cre_id_arquivo' => Contratos::where('num_contrato', $row['numero_contrato_credito'])->select('cre_id_arquivo')->first()->id,
                    'data_movimento' => gmdate('Y-m-d', (($row['data_movimento'] - 25569) * 86400)),
                ]);   
            }else{
                Avalistas::create([
                    'codigo' => $row['codigo'],
                    'cli_id_associado' => Associados::where('documento', $row['cpf_garantidor_credito'])->select('id')->first()->id,
                    'cre_id_arquivo' => Contratos::where('num_contrato', $row['numero_contrato_credito'])->select('cre_id_arquivo')->first()->id,
                    'data_movimento' => gmdate('Y-m-d', (($row['data_movimento'] - 25569) * 86400)),
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
