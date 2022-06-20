<?php

namespace App\Services;

use App\Models\Customer;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeikoService
{

    public static function getGeikoCustomers()
    {
        $response = Http::withHeaders(['chave_empresa' => env('GEIKO_KEY')])
            ->withoutVerifying()
            ->get(self::buildUrl('Cliente'));

        if ($response->ok()) {
            return $response->object();
        }

        return;
    }
    public static function getGeikoCustomer($cnpj)
    {
        $response = Http::withHeaders(['chave_empresa' => env('GEIKO_KEY')])
            ->withoutVerifying()
            ->get(self::buildUrl('Cliente'), ['cpf_cnpj' => $cnpj]);

        $geikoCustomer = $response->object()->clientes;

        if (!empty($geikoCustomer)) {
            Customer::where('cnpj', $cnpj)->update([
                'geiko_id' => $geikoCustomer[0]->codigo
            ]);
            return $geikoCustomer[0]->codigo;
        }

        return false;
    }


    public static function sendCustomerNotification($notification): void
    {
        Http::withHeaders(['chave_empresa' => env('GEIKO_KEY')])
            ->withoutVerifying()
            ->post(self::buildUrl('Ncliente'), [
                "nClientes" => [
                    [
                        "codNotificacaoCli" => $notification->id,
                        "codCli" => $notification->customer_id,
                        "descricao" => "ENTRAR EM CONTATO FINANCEIRO",
                        "dataInclusao" => now(),
                        "dataBaixa" => now()->addYear()
                    ]
                ]
            ]);
    }


    public static function createCustomer(Customer $customer)
    {
        Log::info("criar customer geiko");
    }

    private static function buildUrl(string $endpoint): string
    {
        $baseUrl = env('GEIKO_URL');

        $url = $baseUrl . $endpoint;

        return $url;
    }
}
