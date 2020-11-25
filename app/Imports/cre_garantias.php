<?php

namespace App\Imports;

use App\Models\Contratos;
use App\Models\Associados;
use App\Models\Garantias;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class cre_garantias implements ToCollection, WithBatchInserts, WithChunkReading, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
	    {  
	        $dados = Garantias::where('codigo', $row['codigo'])->first();
	        if(isset($dados)){
	            Garantias::where('codigo', $dados->codigo)->update([
	                'tipo' => $row['tipo_garantia_enquadramento'],
	                'descricao' => $row['garantia_enquadramento'],
	                'cre_id_arquivo' => Contratos::where('num_contrato', $row['numero_contrato_credito'])->select('cre_id_arquivo')->first()->id,
	                'data_movimento' => gmdate('Y-m-d', (($row['data_movimento'] - 25569) * 86400)),
	            ]);   
	        }else{
	            Garantias::create([
	                'codigo' => $row['codigo'],
	                'tipo' => $row['tipo_garantia_enquadramento'],
	                'descricao' => $row['garantia_enquadramento'],
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
