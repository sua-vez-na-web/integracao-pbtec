<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Customer;
use App\Models\GeikoNotification;
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
}
