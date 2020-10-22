<?php

namespace App\Imports;

use App\Models\Associados;
use App\Models\Enderecos;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class EnderecosImport implements ToModel, WithBatchInserts, WithChunkReading
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Enderecos([
            'rua' => $row[0], 
            'bairro' => $row[1], 
            'numero' => $row[2], 
            'complemento' => $row[3], 
            'cidade' => $row[4], 
            'estado' => $row[5], 
            'pais' => 'BRASIL',
            'cli_id_associado' => Associados::where('id_sisbr', $row[6])->select('id')->first()[0],
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
