<?php

namespace App\Http\Controllers;

use App\Http\Requests\Customer\CreateCustomerRequest;
use App\Models\Customer;
use App\Services\BomControleService;
use App\Services\GeikoService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('cnpj')) {

            $customers = Customer::FilterCnpj($request->cnpj)->get();
        } else {
            $customers = Customer::latest()->paginate(20);
        }
        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCustomerRequest $request)
    {

        $customer = Customer::updateOrcreate(['cnpj' => $request->cnpj], $request->all());

        if ($request->has('bomcontrolle_on')) {
            $response = BomControleService::createCustomer($customer);

            if ($response->successful()) {
                $customer->bomcontrole_id = $response->object();
                $customer->save();
                return redirect()->route('customers/create')->withSUccess("Cliente Enviado para o BOM COMTROLLE");
            } else {
                return redirect('customers/create')
                    ->withInput()
                    ->withFail("BOMCONTROLE: " . $response->object()->Mensagem);
            }
        }

        return redirect('/customers/create')->withSuccess("Cliente Cadastrado");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = Customer::find($id);

        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $customer = Customer::find($id)->update($request->all());

        return redirect()->route('customers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
