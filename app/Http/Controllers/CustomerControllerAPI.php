<?php

namespace App\Http\Controllers;

use App\Http\Resources\CustomerAPI;
use App\Models\Customer;
use App\Services\NumValidation;
use Illuminate\Http\Request;

class CustomerControllerAPI extends Controller
{

    public function index()
    {
        $customers = Customer::latest()->paginate(10);
        return [
            "status" => 200,
            "data" => $customers
        ];
    }

    public function store()
    {
        dd('store');
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
        //persist
        $customer = Customer::create($attributes);

        //redirect
        return [
            "status" => 201,
            "data" => $customer
        ];
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
        //Customer::update($attributes);
        $customer->update($attributes);
        //dd($attributes);
        //return redirect('/');
        return [
            "status" => 201,
            "data" => $customer,
            "msg" => 'update successful'
        ];
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        dd($customer);
        return [
            "status" => 1,
            "data" => $customer,
            "msg" => "Blog deleted successfully"
        ];
    }

}
