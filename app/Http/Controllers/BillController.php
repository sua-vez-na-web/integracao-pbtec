<?php

namespace App\Http\Controllers;

use App\Jobs\GetCustomerBillJob;
use App\Jobs\SendGeikoCustomerNotificationJob;
use App\Jobs\UpdateCustomerBillJob;
use App\Models\Bill;
use App\Models\Customer;
use App\Models\GeikoNotification;
use App\Services\BomControleService;
use App\Services\GeikoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bills = Bill::latest()->get();

        return view('bills.index', compact('bills'));
    }

    public function show($id)
    {
        $bill = Bill::find($id);

        return view('bills.show', compact('bill'));
    }

    public function notifygeiko(Request $request)
    {

        $customer = Customer::where('geiko_id', $request->geiko_id)->first();

        if ($customer) {
            DB::beginTransaction();

            $notification = GeikoNotification::updateOrcreate(['bill_id' => $request->id], [
                'bill_id' => $request->bill_id,
                'message' => $request->message,
                'include_at' => $request->include_at ?? now(),
                'removed_at' => $request->removed_at ?? now()->addYear(),
                'customer_id' => $customer->geiko_id
            ]);

            $response = GeikoService::sendCustomerNotification($notification);

            if ($response->successful()) {
                $notification->is_sent = true;
                $notification->save();

                DB::commit();
                return redirect()->route('bills.index')->withSuccess("Resposta GEIKO: " . $response->object());
            } else {

                DB::rollBack();
                return redirect()
                    ->back()
                    ->withInput()
                    ->withFail("ERRO GEIKO: " . $response->object()->Message);
            }
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->withFail("Erro ao eniar notificação: Cliente não localizado no integrador!");
        }
    }

    public function updateBill($faturaId)
    {
        $bill = Bill::findOrFail($faturaId);

        UpdateCustomerBillJob::dispatch($bill);

        $customerBill = BomControleService::getCustomerBill($bill->bill_id);

        if (($customerBill) && ($customerBill->Quitado == true)) {

            $response = GeikoService::updateCustomerNotification($customerBill->Quitado, $bill);

            if ($response) {
                $msg  = "FATURA PAGA: " . $customerBill->Id;
                $msg .= "NOTIFICACAO REMOVIDA";
            } else {
                $msg = "ERRO AO REMOVER NOTIFICACAO";
            }
            return redirect()->back()->withSuccess($msg);
        } else {
            $msg = "FATURA NAO PAGA: " . $bill->bill_id;
            return redirect()->back()->withFail($msg);
        }
    }

    public function getBill($faturaId)
    {
        $bill = Bill::findOrFail($faturaId);
        $customer = $bill->customer;

        $bill = BomControleService::getCustomerBills($customer->bomcontrole_id);


        if ($bill) {

            Bill::updateOrCreate(['bill_id' => $bill->IdFatura], [
                'bill_id' => $bill->IdFatura,
                'customer_id' => $customer->bomcontrole_id,
                'due_date' => $bill->DataPrevista,
                'due_amount' => $bill->ValorPrevisto,
                'updated_at' => now()
            ]);

            return redirect()->back()->withFail("GEROU FATURA ATRASADA: {$bill->IdFatura}  VALOR: {$bill->ValorPrevisto}");
        }


        return redirect()->back()->withSuccess("NAO GEROU FATURA ATRASADA");
    }

    public function notifyBill($faturaId)
    {

        $bill = Bill::findOrFail($faturaId);

        DB::beginTransaction();

        $notification = GeikoNotification::updateOrcreate(['bill_id' => $bill->bill_id], [
            'bill_id' => $bill->bill_id,
            'message' => "ENTRAR EM CONTATO COM FINANCEIRO >>>> INTEGRADOR",
            'include_at' => $bill->include_at ?? now(),
            'removed_at' => $bill->removed_at ?? now()->addYears(50),
            'customer_id' => $bill->customer->geiko_id
        ]);

        $response = GeikoService::sendCustomerNotification($notification);

        if ($response->successful()) {
            $notification->is_sent = true;
            $notification->save();

            DB::commit();

            return redirect()->back()->withFail("NOTIFICACAO CRIADA PELO INTEGRADOR: " . $bill->bill_id);
        } else {
            DB::rollBack();
        }

        return redirect()->back()->withSuccess("NADA A EXECUTAR PELO INTEGRADOR");
    }
}
