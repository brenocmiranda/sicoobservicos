<?php

namespace App\Console\Commands;

use App\Http\Controllers\CreditoCtrl;
use Illuminate\Console\Command;

class Fampe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Fampe:operacoes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envio de informações para o SEBRAE.';

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
    public function handle(CreditoCtrl $action)
    {
        return $action->Fampe();
    }
}
