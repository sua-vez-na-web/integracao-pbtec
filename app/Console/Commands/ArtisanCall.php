<?php

namespace App\Console\Commands;

use App\Jobs\LoggerSlackJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ArtisanCall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Teste de Comando';

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
    public function handle()
    {
        LoggerSlackJob::dispatch('TESTE DE JOB AND SCHEDULE');

        return 0;
    }
}
