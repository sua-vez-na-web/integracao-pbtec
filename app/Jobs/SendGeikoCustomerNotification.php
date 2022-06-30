<?php

namespace App\Jobs;

use App\Models\Customer;
use App\Models\GeikoNotification;
use App\Services\GeikoService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendGeikoCustomerNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    private $customerId;
    private $type;
    private $billId;

    public function __construct($customerId, $billId, $type)
    {
        $this->customerId = $customerId;
        $this->type = $type;
        $this->billId = $billId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $customer = Customer::where('bomcontrole_id', $this->customerId)
            ->whereNotNull('geiko_id')
            ->first();

        if ($customer) {

            $notification = GeikoNotification::where('bill_id', $this->billId)
                ->where('type', 'IN')
                ->first();

            if (!$notification) {

                $notification = GeikoNotification::create([
                    'bill_id' => $this->billId,
                    'message' => "ENTRAR EM CONTATO COM FINANCEIRO",
                    'type' => $this->type,
                    'include_at' => now(),
                    'removed_at' => now()->addYear(),
                    'customer_id' => $customer->geiko_id
                ]);

                // GeikoService::sendCustomerNotification($notification);
            }
        } else {
            Log::info("Nao foi possivel notificar cliente GEIKO - Cliente Inexistente");
        }
    }
}
