<?php

namespace App\Imports;

use App\Models\Associados;
use App\Models\Telefones;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class TelefonesImport implements ToModel, WithBatchInserts, WithChunkReading
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Telefones([
            'numero_celular' => ($row[0] > 0 ? $row[0] : null), 
            'numero_comercial' => ($row[1] > 0 ? $row[1] : null), 
            'numero_residencial' => ($row[2] > 0 ? $row[2] : null), 
            'numero_fax' => ($row[3] > 0 ? $row[3] : null), 
            'numero_recado' => ($row[4] > 0 ? $row[4] : null), 
            'cli_id_associado' => Associados::where('id_sisbr', $row[1])->select('id')->first()[0],
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
