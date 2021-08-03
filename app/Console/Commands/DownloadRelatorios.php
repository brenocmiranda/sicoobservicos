<?php

namespace App\Console\Commands;

use App\Http\Controllers\ImportacoesCtrl;
use Illuminate\Console\Command;

class DownloadRelatorios extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'relatorios:download';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download dos relatórios do Gmail';

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
        return $action->DonwloadRelatorios();
    }
}
