<?php

namespace App\Console\Commands;

use App\Models\Customer;
use App\Services\BomControleService;
use Illuminate\Console\Command;

class GetCustomerBills extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bills:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get customers bills and create record';

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

        $customers = Customer::whereNotNull('bomcontrole_id')->get();

        foreach ($customers as $customer) {

            BomControleService::getCustomerBills($customer->bomcontrole_id);
        }
    }
}
