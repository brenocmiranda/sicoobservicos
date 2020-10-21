<?php

namespace App\Imports;

use App\Models\Associados;
use Maatwebsite\Excel\Concerns\ToModel;

class AssociadosImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Associados([
            'id_sisbr' => $row[0], 
            'nome' => $row[1], 
            'nome_fantasia' => $row[2], 
            'documento' => $row[3], 
            'nivel_risco' => $row[4], 
            'renda' => $row[5], 
            'bens' => $row[6], 
            'nivel_crl' => $row[7], 
            'data_crl' => gmdate('Y-m-d', (($row[8] - 25569) * 86400)), 
            'cod_cnae' => ($row[9] > 0 ? $row[9] : 'NÃO POSSUI'),
            'data_nascimento' => gmdate('Y-m-d', (($row[10] - 25569) * 86400)), 
            'atividade_economica' => $row[11], 
            'sexo' => ($row[12] > 0 ? $row[12] : 'NÃO POSSUI'), 
            'sigla' => $row[13], 
            'funcionario' => $row[14], 
            'data_relacionamento' => gmdate('Y-m-d', (($row[15] - 25569) * 86400)),
            'data_atualizacao' => gmdate('Y-m-d', (($row[16] - 25569) * 86400)), 
            'data_movimento' => gmdate('Y-m-d', (($row[17] - 25569) * 86400)), 
            'PA' => $row[18],
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
