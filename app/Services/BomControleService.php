<?php

namespace App\Services;

use App\Jobs\SendGeikoCustomerNotification;
use App\Models\Bill;
use App\Models\Customer;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BomControleService
{
    public static function getCustomerByCnpj($cnpj)
    {

        $response = Http::withHeaders(['Authorization' => 'ApiKey' . env('BOMCONTROLE_KEY')])
            ->withoutVerifying()
            ->get(self::buildUrl('Cliente/Pesquisar'), ['pesquisa' => $cnpj]);

        if (empty($response->object()))
            return;


        $bomControlleCustomer = $response->object()[0];

        if ($bomControlleCustomer) {
            Customer::where('cnpj', $cnpj)->update([
                'bomcontrole_id' => $bomControlleCustomer->Id
            ]);
        }

        return $bomControlleCustomer->Id;
    }


    public static function getCustomerBills($customerId): void
    {
        $response = HTTP::withHeaders(['Authorization' => "ApiKey" . env("BOMCONTROLE_KEY")])
            ->withoutVerifying()
            ->get(self::buildUrl("/Fatura/VerificarSituacaoCliente/{$customerId}"));

        $bills = $response->object();

        if ($bills) {

            Bill::updateOrCreate(['bill_id' => $bills->IdFatura], [
                'bill_id' => $bills->IdFatura,
                'customer_id' => $customerId,
                'due_date' => $bills->DataPrevista,
                'due_amount' => $bills->ValorPrevisto
            ]);

            SendGeikoCustomerNotification::dispatch($customerId, $bills->IdFatura, 'IN');

            return;
        }

        return;
    }

    public static function createCustomer(Customer $customer)
    {
        Log::info("criar customer bom controlle");
    }

    private static function buildUrl(string $endpoint): string
    {
        $baseUrl = env('BOMCONTROLE_URL');

        $url = $baseUrl . $endpoint;

        return $url;
    }
}
