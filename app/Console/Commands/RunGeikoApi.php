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

        $customers = Customer::all();

        foreach ($customers as $key => $customer) {
            $this->info("Cliente cnpj {$customer->cnpj} = {$key}");
            GeikoService::getGeikoCustomer($customer->cnpj);
        }

        $geikoCustomers = GeikoService::getGeikoCustomers();
        $exitentes = 0;
        $naoExistem = 0;

        foreach ($geikoCustomers->clientes as $geiko) {

            $exists = Customer::where('cnpj', $geiko->cpf_cnpj)
                ->where('geiko_id', $geiko->codigo)
                ->first();

            if (!$exists) {

                Customer::create([
                    'cnpj' => $geiko->cpf_cnpj,
                    'razao_social' => $geiko->razao_social,
                    'nome_fantasia' => $geiko->fantasia,
                    'bomcontrole_id' => null,
                    'geiko_id' => $geiko->codigo
                ]);

                $this->info("Novo Cliente {$geiko->cpf_cnpj} = {$geiko->razao_social}");
                $naoExistem++;
            } else {
                $exitentes++;
            }
        }

        $this->info("NAO EXISTE: {$naoExistem}");
        $this->info("EXISTEM: {$exitentes}");

        return 0;
    }
}
