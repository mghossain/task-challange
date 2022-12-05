<?php

namespace App\Http\Controllers;

use App\Http\Resources\CustomerAPI;
use App\Models\Customer;
use App\Services\NumValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CustomerControllerAPI extends Controller
{

    public function index()
    {
        if (request()->routeIs('index')) {
            return view('index', [
                'customers' => Customer::latest()->paginate(10)
            ]);
        }
        else {
            $customers = Customer::latest()->paginate(10);
            //dd($customers);
            return response()->json($customers);
            // return [
            //     "status" => 200,
            //     "data" => $customers
            // ];
        }

    }

    public function show(Customer $customer)
    {
        return view('show', [
            'customer' => $customer
        ]);
    }

    public function create()
    {
        return view('create');
    }

    public function edit(Customer $customer)
    {
        return view('edit', [
            'customer' => $customer
        ]);
    }

    public function store()
    {
        //dd('store');
        //validate
        $attributes =  request()->validate([
            'name' => ['required', 'max:255'],
            'address' => ['required', 'max:255'],
            'number' => ['required', 'max:255']
        ]);
        //dd($attributes['number']);
        $validatedResponse = Http::post('http://localhost:8000/numvalidate', ['number' => $attributes['number']]);
        $validatedResponse = json_decode($validatedResponse->body());
        //dd($validatedResponse);
        //$validatedResponse = (new NumValidation())->numberValidation($attributes['number']);
        if ($validatedResponse->valid == false) {
            //dd(['here'] . $validatedResponse);
            if (request()->routeIs('store')) {
                return redirect('/create');
            } else {
                return $validatedResponse;
                    // [
                    //     "NumberVerification" => "Invalid Number",
                    //     "status" => 1,
                    //     "msg" => "Store Not Successful",
                    //     "api" => "API Successful",
                    // ];
            }
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
        if (request()->routeIs('store')) {
            return redirect('/users');
        }
        else {
            return response()->json($customer);
            //return $validatedResponse;
            // return [
            //     "status" => 201,
            //     "api" => "API Successful",
            //     "data" => $customer
            // ];
        }
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
        $validatedResponse = Http::post('http://localhost:8000/numvalidate', ['number' => $attributes['number']]);
        $validatedResponse = json_decode($validatedResponse->body());

        //$validatedResponse = (new NumValidation())->numberValidation($attributes['number']);

        //dd($validatedResponse);
        if ($validatedResponse->valid == false) {
            //dd(['here'] . $validatedResponse);
            if (request()->routeIs('update')) {
                return redirect('users/' . $customer->id . '/edit');
            }
            else {
                return $validatedResponse;
            // [
            //     "NumberVerification" => "Invalid Number",
            //     "status" => 1,
            //     "data" => $customer,
            //     "msg" => "Update Not Successful",
            //     "api" => "API Successful",
            // ];
            }

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
        if (request()->routeIs('update')) {
            return redirect('/users');
        }
        else {
            return response()->json($customer);
        // return [
        //     "status" => 201,
        //     "data" => $customer,
        //     "msg" => "Update Successful",
        //     "api" => "API Successful"
        // ];
        }
    }

    public function destroy(Customer $customer)
    {

        $customer->delete();
        //dd($customer);
        if (request()->routeIs('destroy')) {
            return redirect('/users');
        }
        else {
        return [
            "status" => 1,
            "data" => $customer,
            "msg" => "Customer deleted successfully",
            "api" => "API Successful"
        ];
        }
    }

}
