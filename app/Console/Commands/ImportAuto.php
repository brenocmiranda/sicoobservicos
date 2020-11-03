<?php

namespace App\Console\Commands;

use App\Http\Controllers\ImportacoesCtrl;
use Illuminate\Console\Command;

class ImportAuto extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ImportAuto:importar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importacao automática de dados';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(ImportacoesCtrl $action)
    {
        return $action->ImportarAutomatica();
    }
}
