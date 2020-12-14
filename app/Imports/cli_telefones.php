<?php

namespace App\Imports;

use App\Models\Associados;
use App\Models\AssociadosTelefones;
use App\Models\Logs;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;

class cli_telefones implements ToCollection, WithChunkReading, WithHeadingRow, ShouldQueue, WithEvents
{
    use Importable, RegistersEventListeners;

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

    public function registerEvents(): array
    {
        return [
            AfterImport::class => function(AfterImport $event) {
                Logs::create(['mensagem' => 'Inicilizando importação de cli_telefones.xlsx...']);
                Logs::create(['mensagem' => 'Processando o arquivo cli_telefones.xlsx...']);
                Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de cli_telefones.xlsx efetuada com sucesso!</span>']);
            },
            ImportFailed::class => function(ImportFailed $event) {
                Logs::create(['mensagem' => 'Inicilizando importação de cli_telefones.xlsx...']);
                Logs::create(['mensagem' => 'Processando o arquivo cli_telefones.xlsx...']);
                Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cli_telefones.xlsx!</span>']);
            },
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
