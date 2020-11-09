<?php

namespace App\Imports;

use App\Models\ContaCorrente;
use App\Models\CreArquivos;
use App\Models\Produtos;
use App\Models\Finalidades;
use App\Models\Modalidades;
use App\Models\Associados;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class cco_contacorrente implements ToCollection, WithBatchInserts, WithChunkReading, WithHeadingRow
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
            $dados = ContaCorrente::where('cli_id_associado', $associado->id)->first();
            if(isset($dados)){
                CreArquivos::find($dados->cre_id_arquivo)->update([
                    'cre_id_modalidades' => ($row['modalidade_conta_corrente'] == 'CHEQUE ADMINISTRATIVO' ? Modalidades::where('codigo', 801)->select('id')->first()->id : 
                        ($row['modalidade_conta_corrente'] == 'CONTA BENEFÍCIO INSS' ? Modalidades::where('codigo', 802)->select('id')->first()->id : 
                        ($row['modalidade_conta_corrente'] == 'CONTA CONTROLE INTERNO' ? Modalidades::where('codigo', 803)->select('id')->first()->id : 
                        ($row['modalidade_conta_corrente'] == 'CONTA CORRENTE' ? Modalidades::where('codigo', 804)->select('id')->first()->id :
                        ($row['modalidade_conta_corrente'] == 'CONTA INVESTIMENTO' ? Modalidades::where('codigo', 805)->select('id')->first()->id :
                        ($row['modalidade_conta_corrente'] == 'CONTA SALÁRIO' ? Modalidades::where('codigo', 806)->select('id')->first()->id :
                        ($row['modalidade_conta_corrente'] == 'CORRESPONDENTE BANCÁRIO' ? Modalidades::where('codigo', 807)->select('id')->first()->id : Modalidades::where('codigo', 99999)->select('id')->first()->id))))))),
                    'cre_id_produtos' => Produtos::where('codigo', 3)->select('id')->first()->id,
                ]);
                ContaCorrente::where('cli_id_associado', $associado->id)->update([
                    'num_contrato' => $row['numero_conta_corrente'],
                    'situacao' => $row['situacao_conta_corrente'],
                    'modalidade_conta' => $row['modalidade_conta_corrente'],
                    'tipo_conta' => $row['tipo_conta_corrente'],
                    'categoria_conta' => $row['categoria_conta_corrente'],
                    'taxa_limite' => number_format($row['taxa_limite_credito'], 2, ',', ''),
                    'utlizacao_limite' => $row['quantidade_dias_utilizacao_limite_credito'],
                    'valor_contratado' => number_format($row['valor_limite_credito_contratato'], 2, ',', ''),
                    'valor_utilizado' => number_format($row['valor_saldo_devedor_limite_credito'], 2, ',', ''),
                    'taxa_adp' => number_format($row['taxa_adp'], 2, ',', ''),
                    'utlizacao_adp' => $row['quantidade_dias_utilizacao_adp'],
                    'valor_adp' => number_format($row['valor_saldo_devedor_adp'], 2, ',', ''),
                    'sem_movimentacao' => $row['dias_sem_movimentacao'],
                    'ultima_movimentacao' =>  gmdate('Y-m-d', (($row['data_utimo_movimento_conta_corrente'] - 25569) * 86400)),
                    'data_abertura' => gmdate('Y-m-d', (($row['data_abertura_conta_corrente'] - 25569) * 86400)),
                    'data_encerramento' => gmdate('Y-m-d', (($row['data_encerramento_conta_corrente'] - 25569) * 86400)),
                    'data_movimento' => gmdate('Y-m-d', (($row['data_movimento'] - 25569) * 86400)),
                    'cre_id_arquivo' => $dados->cre_id_arquivo,
                ]); 
            }else{
                $arquivo = CreArquivos::create([
                    'cre_id_modalidades' => ($row['modalidade_conta_corrente'] == 'CHEQUE ADMINISTRATIVO' ? Modalidades::where('codigo', 801)->select('id')->first()->id : 
                        ($row['modalidade_conta_corrente'] == 'CONTA BENEFÍCIO INSS' ? Modalidades::where('codigo', 802)->select('id')->first()->id : 
                        ($row['modalidade_conta_corrente'] == 'CONTA CONTROLE INTERNO' ? Modalidades::where('codigo', 803)->select('id')->first()->id : 
                        ($row['modalidade_conta_corrente'] == 'CONTA CORRENTE' ? Modalidades::where('codigo', 804)->select('id')->first()->id :
                        ($row['modalidade_conta_corrente'] == 'CONTA INVESTIMENTO' ? Modalidades::where('codigo', 805)->select('id')->first()->id :
                        ($row['modalidade_conta_corrente'] == 'CONTA SALÁRIO' ? Modalidades::where('codigo', 806)->select('id')->first()->id :
                        ($row['modalidade_conta_corrente'] == 'CORRESPONDENTE BANCÁRIO' ? Modalidades::where('codigo', 807)->select('id')->first()->id : Modalidades::where('codigo', 99999)->select('id')->first()->id))))))),
                    'cre_id_produtos' => Produtos::where('codigo', 3)->select('id')->first()->id,
                ]);
                ContaCorrente::create([
                    'num_contrato' => $row['numero_conta_corrente'],
                    'situacao' => $row['situacao_conta_corrente'],
                    'modalidade_conta' => $row['modalidade_conta_corrente'],
                    'tipo_conta' => $row['tipo_conta_corrente'],
                    'categoria_conta' => $row['categoria_conta_corrente'],
                    'taxa_limite' => number_format($row['taxa_limite_credito'], 2, ',', ''),
                    'utlizacao_limite' => $row['quantidade_dias_utilizacao_limite_credito'],
                    'valor_contratado' => number_format($row['valor_limite_credito_contratato'], 2, ',', ''),
                    'valor_utilizado' => number_format($row['valor_saldo_devedor_limite_credito'], 2, ',', ''),
                    'taxa_adp' => number_format($row['taxa_adp'], 2, ',', ''),
                    'utlizacao_adp' => $row['quantidade_dias_utilizacao_adp'],
                    'valor_adp' => number_format($row['valor_saldo_devedor_adp'], 2, ',', ''),
                    'sem_movimentacao' => $row['dias_sem_movimentacao'],
                    'ultima_movimentacao' =>  gmdate('Y-m-d', (($row['data_utimo_movimento_conta_corrente'] - 25569) * 86400)),
                    'data_abertura' => gmdate('Y-m-d', (($row['data_abertura_conta_corrente'] - 25569) * 86400)),
                    'data_encerramento' => gmdate('Y-m-d', (($row['data_encerramento_conta_corrente'] - 25569) * 86400)),
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
