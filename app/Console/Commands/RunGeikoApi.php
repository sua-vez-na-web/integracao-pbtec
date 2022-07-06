<?php

namespace App\Console\Commands;

use App\Models\Bill;
use App\Models\Customer;
use App\Services\GeikoService;
use Illuminate\Console\Command;

class RunGeikoApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'geiko:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Geiko Customers Data';

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

            GeikoService::getGeikoCustomer($customer->cnpj);
        }

        return 0;
    }
}
