<?php

namespace App\Imports;

use App\Models\Conglomerados;
use App\Models\Associados;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class cli_conglomerados implements ToCollection, WithBatchInserts, WithChunkReading, WithHeadingRow
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
            $dados = Conglomerados::where('cli_id_associado', $associado->id)->first();
            if(isset($dados)){
                Conglomerados::where('cli_id_associado', $associado->id)->update([
                    'codigo' => $row['codigo_grupo_economico'],
                    'descricao' => $row['descricao_do_grupo_economico_do_cliente']
                ]); 
            }else{
                Conglomerados::create([
                    'codigo' => (int) $row['codigo_grupo_economico'], 
                    'descricao' => $row['descricao_do_grupo_economico_do_cliente'],
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
