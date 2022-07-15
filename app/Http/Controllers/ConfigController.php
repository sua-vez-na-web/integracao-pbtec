<?php

namespace App\Http\Controllers;

use App\Jobs\DispathComand;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function run(Request $request)
    {

        DispathComand::dispatch($request->command);

        return redirect()->back()->withSuccess("Comando Enviado...");;
    }
}
