<?php

namespace App\Jobs;

use App\Models\Bill;
use App\Models\Customer;
use App\Services\BomControleService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GetCustomerBillJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    private $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    /**
     * Execute the job.
     *
     * @return void
     */


    public function handle()
    {
        $bill = BomControleService::getCustomerBills($this->customer->bomcontrole_id);

        Log::info("CLIENTE CNPJ: " . $this->customer->cnpj);

        if ($bill) {

            Log::info("Cliente: " . $this->customer->bomcontrole_id . " >>>> GEROU FATURA ATRASADA");
            Log::info(">>>>>>> FATURA: {$bill->IdFatura}  VALOR: {$bill->ValorPrevisto}");

            Bill::updateOrCreate(['bill_id' => $bill->IdFatura], [
                'bill_id' => $bill->IdFatura,
                'customer_id' => $this->customer->bomcontrole_id,
                'due_date' => $bill->DataPrevista,
                'due_amount' => $bill->ValorPrevisto,
                'updated_at' => now()
            ]);
        }
    }
}
