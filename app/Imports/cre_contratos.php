<?php

namespace App\Imports;

use App\Models\Contratos;
use App\Models\Associados;
use App\Models\CreArquivos;
use App\Models\Produtos;
use App\Models\Modalidades;
use App\Models\Associados;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class cre_contratos implements ToCollection, WithBatchInserts, WithChunkReading, WithHeadingRow
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
            $dados = Contratos::where('cli_id_associado', $associado->id)->first();
            if(isset($dados)){
                CreArquivos::find($dados->cre_id_arquivo)->update([
                    'cre_id_modalidades' => Modalidades::where('codigo', $row['codigo_modalidade_produto'])->select('id')->first()->id),
                    'cre_id_produtos' => Produtos::where('codigo', $row['codigo_produto'])->select('id')->first()->id,
                ]);
                Contratos::where('cli_id_associado', $associado->id)->update([
                    'num_contrato' => $row['numero_contrato_credito'],
                    'situacao' => $row['situacao_contrato'],
                    'data_operacao' => gmdate('Y-m-d', (($row['data_operacao_contrato'] - 25569) * 86400)),
                    'data_vencimento' => gmdate('Y-m-d', (($row['data_vencimento_contrato'] - 25569) * 86400)),
                    'valor_contrato' => number_format($row['valor_contrato'], 2, ',', ''),
                    'finalidade' => $row['finalidade_operacao_credito'],
                    'nivel_risco' => $row['nivel_risco_atual'],
                    'taxa_operacao' => number_format($row['taxa_operacao'], 2, ',', ''),
                    'taxa_mora' => number_format($row['taxa_mora'], 2, ',', ''),
                    'taxa_multa' =>  number_format($row['taxa_multa'], 2, ',', ''),
                    'valor_devido' => number_format($row['valor_saldo_devedor_diario'], 2, ',', ''),
                    'qtd_parcelas' => $row['quantidade_parcelas'],
                    'qtd_parcelas_pagas' => $row['quantidade_parcelas_pagas'],
                    'data_movimento' => gmdate('Y-m-d', (($row['data_movimento'] - 25569) * 86400)),
                    'cre_id_arquivo' => $dados->cre_id_arquivo,
            }else{
                $arquivo = CreArquivos::create([
                    'cre_id_modalidades' => Modalidades::where('codigo', $row['codigo_modalidade_produto'])->select('id')->first()->id),
                    'cre_id_produtos' => Produtos::where('codigo', $row['codigo_produto'])->select('id')->first()->id,
                ]);
                Contratos::create([
                    'num_contrato' => $row['numero_contrato_credito'],
                    'situacao' => $row['situacao_contrato'],
                    'data_operacao' => gmdate('Y-m-d', (($row['data_operacao_contrato'] - 25569) * 86400)),
                    'data_vencimento' => gmdate('Y-m-d', (($row['data_vencimento_contrato'] - 25569) * 86400)),
                    'valor_contrato' => number_format($row['valor_contrato'], 2, ',', ''),
                    'finalidade' => $row['finalidade_operacao_credito'],
                    'nivel_risco' => $row['nivel_risco_atual'],
                    'taxa_operacao' => number_format($row['taxa_operacao'], 2, ',', ''),
                    'taxa_mora' => number_format($row['taxa_mora'], 2, ',', ''),
                    'taxa_multa' =>  number_format($row['taxa_multa'], 2, ',', ''),
                    'valor_devido' => number_format($row['valor_saldo_devedor_diario'], 2, ',', ''),
                    'qtd_parcelas' => $row['quantidade_parcelas'],
                    'qtd_parcelas_pagas' => $row['quantidade_parcelas_pagas'],
                    'data_movimento' => gmdate('Y-m-d', (($row['data_movimento'] - 25569) * 86400)),
                    'cre_id_arquivo' => $arquivo->id,
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
