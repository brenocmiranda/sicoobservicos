<?php

namespace App\Imports;

use App\Models\Associados;
use App\Models\AssociadosTelefones;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class cli_telefones implements ToCollection, WithBatchInserts, WithChunkReading, WithHeadingRow
{   
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {   
            $associado = Associados::where('id_sisbr', $row['numero_cliente_sisbr'])->select('id')->first();
            $dados = AssociadosTelefones::where('cli_id_associado', $associado->id)->first();
            if(isset($dados)){
                AssociadosTelefones::where('cli_id_associado', $associado->id)->update([
                    'numero_celular' => $row['telefone_celular'], 
                    'numero_comercial' => $row['telefone_comercial'], 
                    'numero_residencial' => $row['telefone_residencial'], 
                    'numero_fax' => $row['telefone_fax'], 
                    'numero_recado' => $row['telefone_recado']
                ]);
            }else{
                AssociadosTelefones::create([
                    'numero_celular' => $row['telefone_celular'], 
                    'numero_comercial' => $row['telefone_comercial'], 
                    'numero_residencial' => $row['telefone_residencial'], 
                    'numero_fax' => $row['telefone_fax'], 
                    'numero_recado' => $row['telefone_recado'], 
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
