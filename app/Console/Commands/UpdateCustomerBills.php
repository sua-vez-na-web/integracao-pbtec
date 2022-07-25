<?php

namespace App\Console\Commands;

use App\Jobs\UpdateCustomerBillJob;
use App\Models\Bill;
use App\Services\BomControleService;
use App\Services\GeikoService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateCustomerBills extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bills:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Customers Bills';

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

        $bills = Bill::all(['bill_id', 'id']);

        foreach ($bills as $bill) {
            // $this->info("CONSULTAR FATURA: " . $bill->bill_id);

            // $customerBill = BomControleService::getCustomerBill($bill->bill_id);

            // if (($customerBill) && ($customerBill->Quitado == true)) {

            //     $response = GeikoService::updateCustomerNotification($bill->bill_id);


            //     if ($response) {

            //         $this->info("FATURA PAGA: " . $customerBill->Id);
            //         $this->info("NOTIFICACAO REMOVIDA");
            //     } else {
            //         $this->info("ERRO AO REMOVER NOTIFICACAO");
            //     }
            // } else {
            //     $this->info("FATURA NAO PAGA: " . $bill->bill_id);
            // }

            UpdateCustomerBillJob::dispatch($bill);
        }
    }
}
