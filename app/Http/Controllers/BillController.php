<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Customer;
use App\Models\GeikoNotification;
use App\Services\GeikoService;
use Illuminate\Http\Request;

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

        $notifications = GeikoNotification::where('bill_id', $bill->id)->get();

        // dd($notifications, $bill);
        return view('bills.show', compact('bill', 'notifications'));
    }

    public function notifygeiko(Request $request)
    {

        $customer = Customer::find($request->customer_id);

        if ($customer) {

            $notification = GeikoNotification::create([
                'bill_id' => $request->id,
                'message' => $request->message,
                'include_at' => $request->include_at ?? now(),
                'removed_at' => $request->removed_at ?? now()->addYear(),
                'customer_id' => $customer->geiko_id
            ]);

            $response = GeikoService::sendCustomerNotification($notification);

            if ($response->successful()) {
                $notification->is_sent = true;
                $notification->save();

                return redirect()->route('bills.index')->withSuccess("Resposta GEIKO: " . $response->object());
            } else {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withFail("ERRO GEIKO: " . $response->object()->message);
            }
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->withFail("Erro ao eniar notificação: Cliente não localizado no integrador!");
        }
    }
}
