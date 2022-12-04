<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Services\NumValidation;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        return view('index', [
            'customers' => Customer::all()
        ]);
    }

    public function edit(Customer $customer)
    {
        return view('edit', [
            'customer' => $customer
        ]);
    }

    public function update(Request $request, Customer $customer)
    {
        //dd('update');
        $attributes =  request()->validate([
            'name' => ['required', 'max:255'],
            'address' => ['required', 'max:255'],
            'number' => ['required', 'max:255']
        ]);
        //dd($attributes['number']);
        $validatedResponse = (new NumValidation())->numberValidation($attributes['number']);

        //dd($validatedResponse);
        if ($validatedResponse->valid == false) {
            dd(['here'] . $validatedResponse);
            return redirect('/create');
        } else {
            $attributes = array_merge(
                $attributes,
                [
                    'number' => $validatedResponse->international_format,
                    'valid' => $validatedResponse->valid,
                    'countryCode' => $validatedResponse->country_code,
                    'countryName' => $validatedResponse->country_name,
                    'operatorName' => $validatedResponse->carrier
                ]
            );
        }

        $customer->update($attributes);

        return redirect('/');

    }

}
