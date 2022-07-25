<?php

namespace App\Console\Commands;

use App\Jobs\GetCustomerBillJob;
use App\Models\Bill;
use App\Models\Customer;
use App\Services\BomControleService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

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

            // $bill = BomControleService::getCustomerBills($customer->bomcontrole_id);

            // $this->info("CLIENTE CNPJ:" . $customer->cnpj);
            // Log::info("CLIENTE CNPJ:" . $customer->cnpj);

            // if ($bill) {

            //     $this->info("Cliente :" . $customer->bomcontrole_id . " GEROU FATURA ATRASADA");
            //     Log::info("Cliente :" . $customer->bomcontrole_id . " GEROU FATURA ATRASADA");


            //     Bill::updateOrCreate(['bill_id' => $bill->IdFatura], [
            //         'bill_id' => $bill->IdFatura,
            //         'customer_id' => $customer->bomcontrole_id,
            //         'due_date' => $bill->DataPrevista,
            //         'due_amount' => $bill->ValorPrevisto
            //     ]);
            // }

            GetCustomerBillJob::dispatch($customer);
        }
    }
}
