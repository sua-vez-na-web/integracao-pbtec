<?php

namespace App\Services;

use App\Jobs\SendGeikoCustomerNotification;
use App\Models\Bill;
use App\Models\Customer;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use phpDocumentor\Reflection\Types\Boolean;

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
            return Customer::where('cnpj', $cnpj)->update([
                'bomcontrole_id' => $bomControlleCustomer->Id
            ]);
        }
    }


    public static function getCustomerBills($customerId)
    {
        $response = HTTP::withHeaders(['Authorization' => "ApiKey" . env("BOMCONTROLE_KEY")])
            ->withoutVerifying()
            ->get(self::buildUrl("/Fatura/VerificarSituacaoCliente/{$customerId}"));


        if ($response->successful()) {

            return $response->object();
        };
        return false;
    }

    public static function createCustomer(Customer $customer)
    {
        Log::info("criar customer bom controlle");
        Log::info(json_encode($customer));
        Log::info($customer->uf);

        $response = HTTP::withHeaders(['Authorization' => 'ApiKey' . env('BOMCONTROLE_KEY')])
            ->withoutVerifying()
            ->post(self::buildUrl('Cliente/Criar'), [
                "Endereco" => [
                    "TipoLogradouro" => "Rua",
                    "Logradouro" => $customer->logradouro,
                    "Numero" => $customer->numero,
                    "Complemento" => $customer->complemento ?? '',
                    "Bairro" => $customer->bairro,
                    "Cep" => $customer->cep,
                    "Cidade" => $customer->cidade,
                    "Uf" => $customer->uf
                ],
                "Contatos" => [
                    [
                        "Nome" => $customer->contato ?? "",
                        "Email" => $customer->email ?? "",
                        "Telefone" => $customer->telefone ?? "",
                        "Padrao" => true,
                        "Cobranca" => true
                    ]
                ],
                "PessoaJuridica" => [
                    "Documento" => $customer->cnpj,
                    "NomeFantasia" => $customer->nome_fantasia,
                    "RazaoSocial" => $customer->razao_social,
                    "IsentoInscricaoEstadual" => false,
                    "InscricaoEstadual" => $customer->rgie ?? 'ISENTO',
                    "UFInscricaoEstadual" => $customer->uf,
                    "InscricaoMunicipal" => null
                ]
            ]);

        Log::info("BR" . json_encode($response->object()));

        return $response;
    }

    public static function getCustomerBill($faturaId)
    {
        $response = Http::withHeaders(['Authorization' => 'ApiKey' . env('BOMCONTROLE_KEY')])
            ->withoutVerifying()
            ->get(self::buildUrl("/Fatura/Obter/{$faturaId}"));

        if ($response->successful()) {
            return $response->object();
        } else {
            Log::error("ERRO NA API: " . json_encode($response->object()));

            return false;
        }
    }

    private static function buildUrl(string $endpoint): string
    {
        $baseUrl = env('BOMCONTROLE_URL');

        $url = $baseUrl . $endpoint;

        return $url;
    }
}
