<?php

namespace App\Imports;

use App\Models\Associados;
use App\Models\AssociadosBacen;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class cli_bacen implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {   
        $dataBaseAtual = AssociadosBacen::orderBy('data_movimento', 'ASC')->first();
        $dataBaseNova = gmdate('Y-m-d', (($rows[0]['data_movimento'] - 25569) * 86400));
        if(strtotime($dataBaseNova) > strtotime($dataBaseAtual->data_movimento)){
            AssociadosBacen::truncate();
            foreach ($rows as $row) 
            {  
                $dados = AssociadosBacen::where('codigo', $row['codigo'])->first();
                if(isset($dados)){
                        AssociadosBacen::where('codigo', $dados->codigo)->update([
                            'data_movimento' => gmdate('Y-m-d', (($row['data_movimento'] - 25569) * 86400)),
                            'modalidade' => $row['modalidade_bacen'],
                            'submodalidade' => $row['submodalidade_bacen'],
                            'saldo_prejuizo' => number_format($row['valor_prejuizo_sfn'], 2, '.', ''),
                            'saldo_responsabilidade' => number_format($row['valor_saldo_devedor_sfn'], 2, '.', ''),
                            'saldo_credito_liberar' => number_format($row['valor_credito_a_liberar_sfn'], 2, '.', ''),
                            'saldo_avencer' => number_format($row['valor_a_vencer_sfn'], 2, '.', ''),
                            'saldo_avencer_30' => number_format($row['valor_a_vencer_ate_30_dias_sfn'], 2, '.', ''),
                            'saldo_avencer_3160' => number_format($row['valor_a_vencer_31_a_60_dias_sfn'], 2, '.', ''),
                            'saldo_avencer_6190' => number_format($row['valor_a_vencer_61_a_90_dias_sfn'], 2, '.', ''),
                            'saldo_avencer_91180' => number_format($row['valor_a_vencer_91_a_180_dias_sfn'], 2, '.', ''),
                            'saldo_avencer_181360' => number_format($row['valor_a_vencer_181_a_360_dias_sfn'], 2, '.', ''),
                            'saldo_avencer_361720' => number_format($row['valor_a_vencer_361_a_720_dias_sfn'], 2, '.', ''),
                            'saldo_avencer_7211080' => number_format($row['valor_a_vencer_721_a_1080_dias_sfn'], 2, '.', ''),
                            'saldo_avencer_10811440' => number_format($row['valor_a_vencer_1081_a_1440_dias_sfn'], 2, '.', ''),
                            'saldo_avencer_14411800' => number_format($row['valor_a_vencer_1441_a_1800_dias_sfn'], 2, '.', ''),
                            'saldo_avencer_18015400' => number_format($row['valor_a_vencer_1801_a_5400_dias_sfn'], 2, '.', ''),
                            'saldo_avencer_5400' => number_format($row['valor_a_vencer_acima_5400_dias_sfn'], 2, '.', ''),
                            'saldo_avencer_indeterminado' => number_format($row['valor_a_vencer_prazo_indeterminado_sfn'], 2, '.', ''),
                            'saldo_vencido' => number_format($row['valor_vencido_sfn'], 2, '.', ''),
                            'saldo_vencido_1530' => number_format($row['valor_vencido_15_a_30_dias_sfn'], 2, '.', ''),
                            'saldo_vencido_3160' => number_format($row['valor_vencido_31_a_60_dias_sfn'], 2, '.', ''),
                            'saldo_vencido_6190' => number_format($row['valor_vencido_61_a_90_dias_sfn'], 2, '.', ''),
                            'saldo_vencido_91120' => number_format($row['valor_vencido_91_a_120_dias_sfn'], 2, '.', ''),
                            'saldo_vencido_121150' => number_format($row['valor_vencido_121_a_150_dias_sfn'], 2, '.', ''),
                            'saldo_vencido_151180' => number_format($row['valor_vencido_151_a_180_dias_sfn'], 2, '.', ''),
                            'saldo_vencido_181240' => number_format($row['valor_vencido_181_a_240_dias_sfn'], 2, '.', ''),
                            'saldo_vencido_241300' => number_format($row['valor_vencido_241_a_300_dias_sfn'], 2, '.', ''),
                            'saldo_vencido_301360' => number_format($row['valor_vencido_301_a_360_dias_sfn'], 2, '.', ''),
                            'saldo_vencido_361540' => number_format($row['valor_vencido_361_a_540_dias_sfn'], 2, '.', ''),
                            'saldo_vencido_540' => number_format($row['valor_vencido_acima_540_dias_sfn'], 2, '.', ''),
                            'cli_id_associado' => Associados::where('id_sisbr', $row['numero_cliente_sisbr'])->select('id')->first()->id,
                        ]); 
                }else{
                    AssociadosBacen::create([
                        'data_movimento' => gmdate('Y-m-d', (($row['data_movimento'] - 25569) * 86400)),
                        'codigo' => $row['codigo'],
                        'modalidade' => $row['modalidade_bacen'],
                        'submodalidade' => $row['submodalidade_bacen'],
                        'saldo_prejuizo' => number_format($row['valor_prejuizo_sfn'], 2, '.', ''),
                        'saldo_responsabilidade' => number_format($row['valor_saldo_devedor_sfn'], 2, '.', ''),
                        'saldo_credito_liberar' => number_format($row['valor_credito_a_liberar_sfn'], 2, '.', ''),
                        'saldo_avencer' => number_format($row['valor_a_vencer_sfn'], 2, '.', ''),
                        'saldo_avencer_30' => number_format($row['valor_a_vencer_ate_30_dias_sfn'], 2, '.', ''),
                        'saldo_avencer_3160' => number_format($row['valor_a_vencer_31_a_60_dias_sfn'], 2, '.', ''),
                        'saldo_avencer_6190' => number_format($row['valor_a_vencer_61_a_90_dias_sfn'], 2, '.', ''),
                        'saldo_avencer_91180' => number_format($row['valor_a_vencer_91_a_180_dias_sfn'], 2, '.', ''),
                        'saldo_avencer_181360' => number_format($row['valor_a_vencer_181_a_360_dias_sfn'], 2, '.', ''),
                        'saldo_avencer_361720' => number_format($row['valor_a_vencer_361_a_720_dias_sfn'], 2, '.', ''),
                        'saldo_avencer_7211080' => number_format($row['valor_a_vencer_721_a_1080_dias_sfn'], 2, '.', ''),
                        'saldo_avencer_10811440' => number_format($row['valor_a_vencer_1081_a_1440_dias_sfn'], 2, '.', ''),
                        'saldo_avencer_14411800' => number_format($row['valor_a_vencer_1441_a_1800_dias_sfn'], 2, '.', ''),
                        'saldo_avencer_18015400' => number_format($row['valor_a_vencer_1801_a_5400_dias_sfn'], 2, '.', ''),
                        'saldo_avencer_5400' => number_format($row['valor_a_vencer_acima_5400_dias_sfn'], 2, '.', ''),
                        'saldo_avencer_indeterminado' => number_format($row['valor_a_vencer_prazo_indeterminado_sfn'], 2, '.', ''),
                        'saldo_vencido' => number_format($row['valor_vencido_sfn'], 2, '.', ''),
                        'saldo_vencido_1530' => number_format($row['valor_vencido_15_a_30_dias_sfn'], 2, '.', ''),
                        'saldo_vencido_3160' => number_format($row['valor_vencido_31_a_60_dias_sfn'], 2, '.', ''),
                        'saldo_vencido_6190' => number_format($row['valor_vencido_61_a_90_dias_sfn'], 2, '.', ''),
                        'saldo_vencido_91120' => number_format($row['valor_vencido_91_a_120_dias_sfn'], 2, '.', ''),
                        'saldo_vencido_121150' => number_format($row['valor_vencido_121_a_150_dias_sfn'], 2, '.', ''),
                        'saldo_vencido_151180' => number_format($row['valor_vencido_151_a_180_dias_sfn'], 2, '.', ''),
                        'saldo_vencido_181240' => number_format($row['valor_vencido_181_a_240_dias_sfn'], 2, '.', ''),
                        'saldo_vencido_241300' => number_format($row['valor_vencido_241_a_300_dias_sfn'], 2, '.', ''),
                        'saldo_vencido_301360' => number_format($row['valor_vencido_301_a_360_dias_sfn'], 2, '.', ''),
                        'saldo_vencido_361540' => number_format($row['valor_vencido_361_a_540_dias_sfn'], 2, '.', ''),
                        'saldo_vencido_540' => number_format($row['valor_vencido_acima_540_dias_sfn'], 2, '.', ''),
                        'cli_id_associado' => Associados::where('id_sisbr', $row['numero_cliente_sisbr'])->select('id')->first()->id,
                    ]); 
                }
            }  
        }else{
            AssociadosBacen::find(1)->update('data_movimento', date('Y-m-d'));
        }
    }
}
