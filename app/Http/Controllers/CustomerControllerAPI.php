<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CustomerControllerAPI extends Controller
{

    public function __construct() {
        $this->host = env('PHONE_API_HOST');
        $this->port = env('PHONE_API_PORT');
        $this->full_url = $this->host.":".$this->port;
    }

    public function index()
    {
        if (request()->routeIs('index')) {
            return view('index', [
                'customers' => Customer::latest()->paginate(10)
            ]);
        }
        else {
            $customers = Customer::latest()->paginate(10);

            return response()->json($customers);
        }

    }

    public function show(Customer $customer)
    {
        if (request()->routeIs('show')) {
            return view('show', [
                'customer' => $customer
            ]);
        } else {
            return response()->json($customer);
        }
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
        //validate
        $attributes =  request()->validate([
            'name' => ['required', 'max:255'],
            'address' => ['required', 'max:255'],
            'number' => ['required', 'max:255']
        ]);

        $validatedResponse = Http::post($this->full_url.'/numvalidate', ['number' => $attributes['number']]);
        $validatedResponse = json_decode($validatedResponse->body());

        if ($validatedResponse->valid == false) {

            if (request()->routeIs('store')) {
                return redirect('/create');
            } else {
                return $validatedResponse;

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
        $validatedResponse = Http::post($this->full_url.'/numvalidate', ['number' => $attributes['number']]);
        $validatedResponse = json_decode($validatedResponse->body());

        if ($validatedResponse->valid == false) {
            //dd(['here'] . $validatedResponse);
            if (request()->routeIs('update')) {
                return redirect('users/' . $customer->id . '/edit');
            }
            else {
                return $validatedResponse;
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

        if (request()->routeIs('update')) {
            return redirect('/users');
        }
        else {
            return response()->json($customer);
        }
    }

    public function destroy(Customer $customer)
    {

        $customer->delete();

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
