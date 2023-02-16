<?php

namespace App\Jobs;

use App\Models\Bill;
use App\Services\BomControleService;
use App\Services\GeikoService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UpdateCustomerBillJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    private $bill;

    public function __construct(Bill $bill)
    {
        $this->bill = $bill;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info("CONSULTAR FATURA: " . $this->bill->bill_id);

        $customerBill = BomControleService::getCustomerBill($this->bill->bill_id);

        if (($customerBill) && ($customerBill->Quitado == true)) {

            $response = GeikoService::updateCustomerNotification($this->bill, $customerBill->Quitado);

            if ($response) {
                Log::info("FATURA PAGA: " . $customerBill->Id);
                Log::info("NOTIFICACAO REMOVIDA");
            } else {
                Log::warning("ERRO AO REMOVER NOTIFICACAO");
            }
        } else {
            Log::info("FATURA NAO PAGA: " . $this->bill->bill_id);
        }
    }
}
