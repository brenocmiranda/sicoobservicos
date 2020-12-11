<?php

namespace App\Imports;

use App\Models\Associados;
use App\Models\AssociadosEmails;
use App\Models\Logs;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;

class cli_emails implements ToCollection, WithChunkReading, WithHeadingRow, ShouldQueue, WithEvents
{
    use RegistersEventListeners;

    public function collection(Collection $rows)
    {
        Logs::create(['mensagem' => 'Inicilizando importação de cli_emails.xlsx...']);
        Logs::create(['mensagem' => 'Processando o arquivo cli_emails.xlsx...']);
        foreach ($rows as $row) 
        {  
            $associado = Associados::where('id_sisbr', $row['numero_cliente_sisbr'])->select('id')->first();
            $dados = AssociadosEmails::where('cli_id_associado', $associado->id)->first();
            if(isset($dados)){
                AssociadosEmails::where('cli_id_associado', $associado->id)->update([
                    'email' => $row['email']
                ]); 
            }else{
                AssociadosEmails::create([
                    'email' => $row['email'], 
                    'cli_id_associado' => Associados::where('id_sisbr', $row['numero_cliente_sisbr'])->select('id')->first()->id,
                ]); 
            }
        }   
    }

    public function registerEvents(): array
    {
        return [
            AfterImport::class => function(AfterImport $event) {
                Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de cli_emails.xlsx efetuada com sucesso!</span>']);
            },
            ImportFailed::class => function(ImportFailed $event) {
               Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cli_emails.xlsx!</span>']);
            },
        ];
    }

    public function chunkSize(): int
    {
        return 50000;
    }
}
