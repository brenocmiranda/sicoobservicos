<?php

namespace App\Imports;

use App\Models\Associados;
use App\Models\AssociadosEnderecos;
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

class cli_enderecos implements ToCollection, WithChunkReading, WithHeadingRow, ShouldQueue, WithEvents
{
    use Importable, RegistersEventListeners;

    public function collection(Collection $rows)
    {    
        foreach ($rows as $row) 
        {   
            $associado = Associados::where('id_sisbr', $row['numero_cliente_sisbr'])->select('id')->first();
            $dados = AssociadosEnderecos::where('cli_id_associado', $associado->id)->first();
            if(isset($dados)){
                 AssociadosEnderecos::where('cli_id_associado', $associado->id)->update([
                    'rua' => $row['logradouro'], 
                    'bairro' => $row['bairro'], 
                    'numero' => $row['numero_logradouro'], 
                    'complemento' => $row['complemento_logradouro'], 
                    'cidade' => $row['municipio'], 
                    'estado' => $row['uf'], 
                    'pais' => 'BRASIL'
                ]);
            }else{
                AssociadosEnderecos::create([
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

    public function registerEvents(): array
    {
        return [
            AfterImport::class => function(AfterImport $event) {
                Logs::create(['mensagem' => 'Inicilizando importação de cli_enderecos.xlsx...']);
                Logs::create(['mensagem' => 'Processando o arquivo cli_enderecos.xlsx...']);
                Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de cli_enderecos.xlsx efetuada com sucesso!</span>']);
            },
            ImportFailed::class => function(ImportFailed $event) {
                Logs::create(['mensagem' => 'Inicilizando importação de cli_enderecos.xlsx...']);
                Logs::create(['mensagem' => 'Processando o arquivo cli_enderecos.xlsx...']);
                Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cli_enderecos.xlsx!</span>']);
            },
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
