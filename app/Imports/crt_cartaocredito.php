<?php

namespace App\Imports;

use App\Models\CartaoCredito;
use App\Models\Associados;
use App\Models\ContratosArquivos;
use App\Models\ProdutosCred;
use App\Models\Modalidades;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class crt_cartaocredito implements ToCollection, WithBatchInserts, WithChunkReading, WithHeadingRow
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
            $dados = CartaoCredito::where('num_contrato', $row['numero_conta_cartao'])->first();
            if(isset($dados)){
                ContratosArquivos::find($dados->cre_id_arquivo)->update([
                    'cre_id_modalidades' => Modalidades::where('codigo', 99999)->select('id')->first()->id,
                    'cre_id_produtos' => ProdutosCred::where('codigo', 99)->select('id')->first()->id,
                ]);
                CartaoCredito::where('num_contrato', $row['numero_conta_cartao'])->update([
                    'situacao' => $row['situacao_conta_cartao'],
                    'cod_cliente' => $row['codigo_cliente'],
                    'funcao_cartao' => $row['funcao_cartao'],
                    'produto_cartao' => $row['produto_cartao'],
                    'bandeira_cartao' => $row['descricao_da_bandeira_cartao'],
                    'fatura' => $row['indicador_fatura_online'],
                    'venc_fatura' => $row['dia_vencimento_fatura'],
                    'data_abertura' => gmdate('Y-m-d', (($row['data_abertura_conta'] - 25569) * 86400)),
                    'data_limite' => gmdate('Y-m-d', (($row['data_limite'] - 25569) * 86400)),
                    'data_fechamento' => gmdate('Y-m-d', (($row['data_fechamento_conta'] - 25569) * 86400)),
                    'valor_atribuido' => number_format($row['valor_limite_atribuido'], 2, '.', ''),
                    'valor_disponivel' => number_format($row['valor_limite_disponivel'], 2, '.', ''),
                    'valor_utilizado' => number_format($row['valor_limite_utilizado'], 2, '.', ''),
                    'data_movimento' => gmdate('Y-m-d', (($row['data_movimento'] - 25569) * 86400)),
                    'cre_id_arquivo' => $dados->cre_id_arquivo
                ]);
            }else{
                $arquivo = ContratosArquivos::create([
                    'cre_id_modalidades' => Modalidades::where('codigo', 99999)->select('id')->first()->id,
                    'cre_id_produtos' => ProdutosCred::where('codigo', 99)->select('id')->first()->id,
                ]);
                CartaoCredito::create([
                    'num_contrato' => (int) $row['numero_conta_cartao'],
                    'situacao' => $row['situacao_conta_cartao'],
                    'cod_cliente' => $row['codigo_cliente'],
                    'funcao_cartao' => $row['funcao_cartao'],
                    'produto_cartao' => $row['produto_cartao'],
                    'bandeira_cartao' => $row['descricao_da_bandeira_cartao'],
                    'fatura' => $row['indicador_fatura_online'],
                    'venc_fatura' => $row['dia_vencimento_fatura'],
                    'data_abertura' => gmdate('Y-m-d', (($row['data_abertura_conta'] - 25569) * 86400)),
                    'data_limite' => gmdate('Y-m-d', (($row['data_limite'] - 25569) * 86400)),
                    'data_fechamento' => gmdate('Y-m-d', (($row['data_fechamento_conta'] - 25569) * 86400)),
                    'valor_atribuido' => number_format($row['valor_limite_atribuido'], 2, '.', ''),
                    'valor_disponivel' => number_format($row['valor_limite_disponivel'], 2, '.', ''),
                    'valor_utilizado' => number_format($row['valor_limite_utilizado'], 2, '.', ''),
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
