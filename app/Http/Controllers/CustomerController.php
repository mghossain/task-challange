<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Services\NumValidation;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $customers = Customer::latest()->paginate(10);
        return [
            "status" => 200,
            "data" => $customers
        ];

        // return view('index', [
        //     'customers' => Customer::all()
        // ]);
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
    public function store()
    {
        //validate
        $attributes =  request()->validate([
            'name' => ['required', 'max:255'],
            'address' => ['required', 'max:255'],
            'number' => ['required', 'max:255']
        ]);
        //dd($attributes['number']);
        $validatedResponse = (new NumValidation())->numberValidation($attributes['number']);

        //dd($validatedResponse);
        if ($validatedResponse->valid == false) {
            dd(['here']. $validatedResponse);
            return redirect('/create');
        }
        else{
            $attributes = array_merge(
                $attributes, [
                    'number' => $validatedResponse->international_format,
                    'valid' => $validatedResponse->valid,
                    'countryCode' => $validatedResponse->country_code,
                    'countryName' => $validatedResponse->country_name,
                    'operatorName' => $validatedResponse->carrier
            ]);
        }
        //persist
        $customer = Customer::create($attributes);

        //redirect
        return [
            "status" => 201,
            "data" => $customer
        ];


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
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
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
