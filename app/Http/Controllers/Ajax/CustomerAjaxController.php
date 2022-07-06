<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Services\GeikoService;
use Illuminate\Http\Request;

class CustomerAjaxController extends Controller
{
    public function consultaClienteByCNPJ(Request $request)
    {
        $geikoService = new GeikoService();

        $response = $geikoService->getGeikoCustomer($request->cnpj);


        if ($response) {
            return response()->json([
                'success' => true,
                'data' => $response,
                'message' => "Cliente localizdo GEIKO."
            ], 200);
        }

        return response()->json([
            'success' => false,
            'data' => "",
            'message' => "Novo não Localizado"
        ], 200);
    }
}
