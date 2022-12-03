<?php

namespace App\Http\Controllers;

use App\Services\NumValidation;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class ValidationController extends Controller
{
    public function __invoke(NumValidation $numValidation)
    {
        request()->validate([
            'number' => ['required', 'min:3', 'max:255']
        ]);

        try {
            $validatedResponse = $numValidation->numberValidation(request('number'));
        } catch (Exception $e) {
            throw ValidationException::withMessages([
                'number' => 'This number could not be verified!'
            ]);
        }
        //dd($validatedResponse->carrier);
        return redirect('/');
    }
}
