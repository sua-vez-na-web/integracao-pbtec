<?php

namespace App\Console\Commands;

use App\Jobs\SendGeikoCustomerNotificationJob;
use App\Models\Bill;
use App\Models\GeikoNotification;
use App\Services\GeikoService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RunGeikoNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'geiko:notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Geiko Notifications';

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

        $bills = Bill::all(['bill_id', 'customer_id', 'id']);

        foreach ($bills as $bill) {
            // DB::beginTransaction();

            // $notification = GeikoNotification::updateOrcreate(['bill_id' => $bill->bill_id], [
            //     'bill_id' => $bill->bill_id,
            //     'message' => "ENTRAR EM CONTATO COM FINANCEIRO INTEGRADOR",
            //     'include_at' => $bill->include_at ?? now(),
            //     'removed_at' => $bill->removed_at ?? now()->addYears(50),
            //     'customer_id' => $bill->customer->geiko_id
            // ]);

            // $response = GeikoService::sendCustomerNotification($notification);

            // if ($response->successful()) {
            //     $notification->is_sent = true;
            //     $notification->save();

            //     DB::commit();
            //     $this->info("NOTIFICACAO CRIADA: " . $bill->bill_id);
            //     $this->info("Resposta GEIKO: " . $response->object());
            // } else {
            //     DB::rollBack();
            // }

            SendGeikoCustomerNotificationJob::dispatch($bill);
        }
    }
}
