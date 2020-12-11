<?php

namespace App\Imports;

use App\Models\Associados;
use App\Models\AssociadosConglomerados;
use App\Models\Logs;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;

class cli_conglomerados implements ToCollection, WithChunkReading, WithHeadingRow, ShouldQueue, WithEvents
{
    use RegistersEventListeners;

    public function collection(Collection $rows)
    {
        Logs::create(['mensagem' => 'Inicilizando importação de cli_conglomerados.xlsx...']);
        Logs::create(['mensagem' => 'Processando o arquivo cli_conglomerados.xlsx...']);
        foreach ($rows as $row) 
        {  
            $associado = Associados::where('id_sisbr', $row['numero_cliente_sisbr'])->select('id')->first();
            $dados = AssociadosConglomerados::where('cli_id_associado', $associado->id)->first();
            if(isset($dados)){
                AssociadosConglomerados::where('cli_id_associado', $associado->id)->update([
                    'codigo' => $row['codigo_grupo_economico'],
                    'descricao' => $row['descricao_do_grupo_economico_do_cliente']
                ]); 
            }else{
                AssociadosConglomerados::create([
                    'codigo' => (int) $row['codigo_grupo_economico'], 
                    'descricao' => $row['descricao_do_grupo_economico_do_cliente'],
                    'cli_id_associado' => Associados::where('id_sisbr', $row['numero_cliente_sisbr'])->select('id')->first()->id,
                ]); 
            }
        }   
    }

    public function registerEvents(): array
    {
        return [
            AfterImport::class => function(AfterImport $event) {
                Logs::create(['mensagem' => '<span class="text-success font-weight-bold">Importação de cli_conglomerados.xlsx efetuada com sucesso!</span>']);
            },
            ImportFailed::class => function(ImportFailed $event) {
               Logs::create(['mensagem' => '<span class="text-danger font-weight-bold">Erro na importação do arquivo cli_conglomerados.xlsx!</span>']);
            },
        ];
    }

    public function chunkSize(): int
    {
        return 50000;
    }
}
