<?php

namespace App\Console\Commands;

use App\Models\Customer;
use App\Services\BomControleService;
use Illuminate\Console\Command;

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

        $customers = Customer::all();

        foreach ($customers as $key => $customer) {
            $this->info("Cliente cnpj {$customer->cnpj} = {$key}");

            $customerId = BomControleService::getCustomerByCnpj($customer->cnpj);

            if ($customerId) {

                BomControleService::getCustomerBills($customerId);
            }
        }

        return 0;
    }
}
