<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Returns Customers List in JSON
     * @return \Illuminate\Http\JsonResponse
     */
    public function json()
    {
        return response()->json(Customer::all(), 200);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('customers.index');
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
        $this->validate($request, [
           'name' => [ 'required', 'string', 'min:5', 'max:45'],
           'type' => [ 'required', 'string', 'min:5', 'max:45'],
        ]);

        return Customer::create([
           'name' => $request->name,
           'type' => $request->type,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $customer
     * @return Customer
     */
    public function update(Request $request, Customer $customer)
    {
        $this->validate($request, [
            'name' => [ 'required', 'string', 'min:5', 'max:45'],
            'type' => [ 'required', 'string', 'min:5', 'max:45'],
        ]);

        $customer->update([
            'name' => $request->name,
            'type' => $request->type,
        ]);

        return  $customer;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return response(null, 204);
    }
}
