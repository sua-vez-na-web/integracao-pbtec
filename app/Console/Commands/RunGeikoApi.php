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

        $geikoCustomers = GeikoService::getGeikoCustomers();


        foreach ($geikoCustomers->clientes as $geiko) {

            $this->info('Consultando Cliente: ' . $geiko->razao_social);
            $this->info('CNPJ: ' . $geiko->cpf_cnpj);

            $customer = Customer::where('cnpj', $geiko->cpf_cnpj)
                ->first();

            if ($customer) {
                $customer->geiko_id = $geiko->codigo;
                $customer->save();

                $this->info("Cliente Atualizado: " . $customer->cnpj);
            } else {
                $this->info("Cleinte não localizdo no integrador");
            }
        }
    }
}
