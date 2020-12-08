<?php

namespace App\Imports;

use App\Models\Contratos;
use App\Models\Associados;
use App\Models\ContratosArquivos;
use App\Models\ProdutosCred;
use App\Models\Modalidades;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class cre_contratos_mensal implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        $dataBase = Contratos::orderBy('data_movimento', 'DESC')->first();
        foreach ($rows as $row) 
        {  
       		$dados = Contratos::where('num_contrato', $row['numero_contrato_credito'])->first();
       		$dados1 = Modalidades::where('codigo', $row['codigo_modalidade_produto'])->first();

       		if(isset($dados)){
	        	if(strtotime($dados->data_movimento) != strtotime($dataBase->data_movimento)){
	              	if(isset($dados1)){
	                  	Modalidades::where('codigo', $row['codigo_modalidade_produto'])->update([
	                        'nome' => $row['modalidade_produto'],
	                        'sigla' => $row['sigla_modalidade_produto'],
	                    ]);
	                }else{
	                    Modalidades::create([
	                        'nome' => $row['modalidade_produto'],
	                        'codigo' => $row['codigo_modalidade_produto'],
	                        'sigla' => $row['sigla_modalidade_produto'],
	                        'status' => 1,
	                    ]);
	                }
					ContratosArquivos::find($dados->cre_id_arquivo)->update([
                    	'cre_id_modalidades' => Modalidades::where('codigo', $row['codigo_modalidade_produto'])->select('id')->first()->id,
                    	'cre_id_produtos' => ProdutosCred::where('codigo', $row['codigo_produto'])->select('id')->first()->id,
                	]);
	                Contratos::where('num_contrato', $row['numero_contrato_credito'])->update([
	                    'num_contrato' => (int) $row['numero_contrato_credito'],
	                    'situacao' => $row['situacao_contrato'],
	                    'data_operacao' => gmdate('Y-m-d', (($row['data_operacao_contrato'] - 25569) * 86400)),
	                    'data_vencimento' => gmdate('Y-m-d', (($row['data_vencimento_contrato'] - 25569) * 86400)),
	                    'valor_contrato' => ($row['situacao_contrato'] == 'QUITADO' ? $dados->valor_contrato : number_format($row['valor_contrato'], 2, '.', '')),
	                    'finalidade' => $row['finalidade_operacao_credito'],
	                    'nivel_risco' => 'NÃO POSSUI',
	                    'taxa_operacao' => number_format($row['taxa_operacao'], 2, '.', ''),
	                    'taxa_mora' => number_format($row['taxa_mora'], 2, '.', ''),
	                    'taxa_multa' =>  number_format($row['taxa_multa'], 2, '.', ''),
	                    'valor_devido' => $dados->valor_devido,
	                    'qtd_parcelas' => $row['quantidade_de_parcelas'],
	                    'qtd_parcelas_pagas' => ($row['situacao_contrato'] == 'QUITADO' ? $row['quantidade_de_parcelas'] : 0),
	                    'data_movimento' => '1900-01-01',
	                    'cre_id_arquivo' => $dados->cre_id_arquivo,
	                    'cli_id_associado' => Associados::where('id_sisbr', $row['numero_cliente_sisbr'])->select('id')->first()->id,
	                ]); 
	            }
	        }else{
	        	if(isset($dados1)){
	                  	Modalidades::where('codigo', $row['codigo_modalidade_produto'])->update([
	                        'nome' => $row['modalidade_produto'],
	                        'sigla' => $row['sigla_modalidade_produto'],
	                    ]);
                }else{
                    Modalidades::create([
                        'nome' => $row['modalidade_produto'],
                        'codigo' => $row['codigo_modalidade_produto'],
                        'sigla' => $row['sigla_modalidade_produto'],
                        'status' => 1,
                    ]);
                }
                $arquivo = ContratosArquivos::create([
                    'cre_id_modalidades' => Modalidades::where('codigo', $row['codigo_modalidade_produto'])->select('id')->first()->id,
                    'cre_id_produtos' => ProdutosCred::where('codigo', $row['codigo_produto'])->select('id')->first()->id,
                ]);
                Contratos::create([
                    'num_contrato' => (int) $row['numero_contrato_credito'],
                    'situacao' => $row['situacao_contrato'],
                    'data_operacao' => gmdate('Y-m-d', (($row['data_operacao_contrato'] - 25569) * 86400)),
                    'data_vencimento' => gmdate('Y-m-d', (($row['data_vencimento_contrato'] - 25569) * 86400)),
                    'valor_contrato' => ($row['situacao_contrato'] == 'QUITADO' ? $dados->valor_contrato : number_format($row['valor_contrato'], 2, '.', '')),
                    'finalidade' => $row['finalidade_operacao_credito'],
                    'nivel_risco' => 'NÃO POSSUI',
                    'taxa_operacao' => number_format($row['taxa_operacao'], 2, '.', ''),
                    'taxa_mora' => number_format($row['taxa_mora'], 2, '.', ''),
                    'taxa_multa' =>  number_format($row['taxa_multa'], 2, '.', ''),
                    'valor_devido' => 0,
                    'qtd_parcelas' => $row['quantidade_de_parcelas'],
                    'qtd_parcelas_pagas' => ($row['situacao_contrato'] == 'QUITADO' ? $row['quantidade_de_parcelas'] : 0),
                    'data_movimento' => '1900-01-01',
                    'cre_id_arquivo' => $arquivo->id,
                    'cli_id_associado' => Associados::where('id_sisbr', $row['numero_cliente_sisbr'])->select('id')->first()->id,
                ]); 
	        }
        }
    }
}
