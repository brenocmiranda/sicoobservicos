<?php

namespace App\Imports;

use App\Models\Associados;
use App\Models\Enderecos;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EnderecosImport implements ToCollection, WithBatchInserts, WithChunkReading, WithHeadingRow
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
            $dados = Enderecos::where('cli_id_associado', $associado->id)->first();
            if(isset($dados)){
                 Enderecos::where('cli_id_associado', $associado->id)->update([
                    'rua' => $row['logradouro'], 
                    'bairro' => $row['bairro'], 
                    'numero' => $row['numero_logradouro'], 
                    'complemento' => $row['complemento_logradouro'], 
                    'cidade' => $row['municipio'], 
                    'estado' => $row['uf'], 
                    'pais' => 'BRASIL'
                ]);
            }else{
                Enderecos::create([
                    'rua' => $row['logradouro'], 
                    'bairro' => $row['bairro'], 
                    'numero' => $row['numero_logradouro'], 
                    'complemento' => $row['complemento_logradouro'], 
                    'cidade' => $row['municipio'], 
                    'estado' => $row['uf'], 
                    'pais' => 'BRASIL',
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
