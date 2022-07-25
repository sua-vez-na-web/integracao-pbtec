<?php

namespace App\Jobs;

use App\Models\Bill;
use App\Models\Customer;
use App\Models\GeikoNotification;
use App\Services\GeikoService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SendGeikoCustomerNotificationJob implements ShouldQueue
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
        DB::beginTransaction();

        $notification = GeikoNotification::updateOrcreate(['bill_id' => $this->bill->bill_id], [
            'bill_id' => $this->bill->bill_id,
            'message' => "ENTRAR EM CONTATO COM FINANCEIRO >>>> INTEGRADOR",
            'include_at' => $this->bill->include_at ?? now(),
            'removed_at' => $this->bill->removed_at ?? now()->addYears(50),
            'customer_id' => $this->bill->customer->geiko_id
        ]);

        $response = GeikoService::sendCustomerNotification($notification);

        if ($response->successful()) {
            $notification->is_sent = true;
            $notification->save();

            DB::commit();
            Log::info("NOTIFICACAO CRIADA PELO INTEGRADOR: " . $this->bill->bill_id);
            Log::info("Resposta Geiko API: " . $response->object());
        } else {
            DB::rollBack();
        }
    }
}
