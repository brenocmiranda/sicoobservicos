<?php

namespace App\Console\Commands;

use App\Http\Controllers\TecnologiaCtrl;
use Illuminate\Console\Command;

class TempoVida extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'TempoVida:monitorar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Monitoramento dos chamados por status';

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
    public function handle(TecnologiaCtrl $action)
    {
        return $action->MonitorarTempoVidaStatus();
    }
}
