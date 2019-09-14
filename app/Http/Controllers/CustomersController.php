<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Customer;
use App\Http\Resources\Customer as CustomerResource;

class CustomersController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get all the data 
        $customers = Customer::paginate(10);
        //Added pagination because I can
        return CustomerResource::collection($customers);
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $customer = $request->isMethod('put') ? Customer::findOrFail($request->customer_id) : new Customer;
        $customer->id = $request->input('customer_id');
        $customer->email = $request->input('email');
        $customer->firstname = $request->input('firstname');
        $customer->lastname = $request->input('lastname');
        $customer->phone = $request->input('phone');
        $customer->regtime = $request->input('regtime');

        if ($customer->save()) {
            return new CustomerResource($customer);
        }
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // This is used to return a single object from the db
        $customer = Customer::findOrFail($id);

        return new CustomerResource($customer);
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);

        if ($customer->delete()) {
            return new CustomerResource($customer);
        }
    }
}
