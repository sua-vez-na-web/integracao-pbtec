<?php

use App\Models\Customer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeCnpjUnmask extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $customers = Customer::all();

        foreach ($customers as $customer) {
            $noMask = str_replace([".", "/", "-"], "", $customer->cnpj);

            Customer::where('cnpj', $customer->cnpj)
                ->update(['cnpj' => $noMask]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
