<?php

namespace App\Services;

use App\Models\Bill;
use App\Models\Customer;
use App\Models\GeikoNotification;
use Illuminate\Support\Facades\DB;
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

            return $geikoCustomer[0];
        }

        return false;
    }


    public static function sendCustomerNotification($notification)
    {

        return Http::withHeaders(['chave_empresa' => env('GEIKO_KEY')])
            ->withoutVerifying()
            ->post(self::buildUrl('Ncliente'), [
                "nClientes" => [
                    [
                        "codNotificacaoCli" => $notification->customer_id,
                        "codCli" => $notification->customer_id,
                        "descricao" => $notification->message,
                        "dataInclusao" => $notification->include_at->format('Y-m-d'),
                        "dataBaixa" => $notification->removed_at->format('Y-m-d')
                    ]
                ]
            ]);
    }

    public static function updateCustomerNotification($billId)
    {
        $notification =  GeikoNotification::where('bill_id', $billId)
            ->whereNotNull('customer_id')
            ->first();

        if ($notification) {
            DB::beginTransaction();

            $response =  Http::withHeaders(['chave_empresa' => env('GEIKO_KEY')])
                ->withoutVerifying()
                ->post(self::buildUrl('Ncliente'), [
                    "nClientes" => [
                        [
                            "codNotificacaoCli" => $notification->customer_id,
                            "codCli" => $notification->customer_id,
                            "descricao" => "REMOVEU NOTIFICACAO PELO INTEGRADOR",
                            "dataInclusao" => $notification->include_at->format('Y-m-d'),
                            "dataBaixa" => $notification->removed_at->format('Y-m-d')
                        ]
                    ]
                ]);

            if ($response->successful()) {

                Log::info("REMOVEU NOTIFICACAO DE: " . $notification->id . $billId);

                $notification->message = "REMOVEU NOTIFICACAO INTEGRADOR";
                $notification->save();

                $bill = Bill::where('bill_id', $billId)->first();
                $bill->delete();

                DB::commit();

                return true;
            }

            DB::rollBack();
            return false;
        } else {
            Log::info("NAO ACHOU NOTIFICACAO PARA: " . $billId);
            return false;
        }
    }


    public static function createCustomer(Customer $customer)
    {
        $response = Http::withHeaders(['chave_empresa' => env('GEIKO_KEY')])
            ->withoutVerifying()
            ->post(self::buildUrl('PostInCli'), [
                "razao" => $customer->razao_social,
                "fantasia" => $customer->fantasia,
                "tipopessoa" => $customer->tipo_cadastro,
                "cpfcnpj" => $customer->cnpj,
                "ativo" => true,
                "contato" => $customer->contato,
                "telefone" => $customer->telefone,
                "email" => $customer->email,
                "cep" => $customer->cep,
                "endereco" => $customer->logradouro,
                "bairro" => $customer->bairro,
                "senha" => " ",
                "rgie" => " "
            ]);

        Log::info("GEIKO CREATE" . json_encode($response));
    }

    private static function buildUrl(string $endpoint): string
    {
        $baseUrl = env('GEIKO_URL');

        $url = $baseUrl . $endpoint;

        return $url;
    }
}
