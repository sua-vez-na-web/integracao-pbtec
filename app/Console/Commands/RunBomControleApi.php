<?php

namespace App\Console\Commands;

use App\Models\Customer;
use App\Services\BomControleService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RunBomControleApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bomcontrolle:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update status of customers from Bom Controlle Api';

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

        $customers = Customer::all(['id', 'cnpj']);

        foreach ($customers as $key => $customer) {

            $this->info("Cliente cnpj {$customer->cnpj} = {$key}");
            Log::info("Cliente cnpj {$customer->cnpj} = {$key}");

            BomControleService::getCustomerByCnpj($customer->cnpj);
        }

        return 0;
    }
}
