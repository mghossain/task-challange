<?php

namespace Database\Factories;

use App\Services\NumValidation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $number = str_replace(array("+"), '', fake()->e164PhoneNumber);
        $validatedResponse = (new NumValidation())->numberValidation($number);
        //dd($validatedResponse->carrier);
        return [
            'name' => fake()->name(),
            'address' => fake()->address(),
            'number' => $validatedResponse->international_format,
            'valid' => $validatedResponse->valid,
            'countryCode' => $validatedResponse->country_code,
            'countryName' => $validatedResponse->country_name,
            'operatorName' => $validatedResponse->carrier
        ];

            // 'number' => $number,
            // 'valid' => true,
            // 'countryCode' => "us",
            // 'countryName' => "lb",
            // 'operatorName' => 'alfa'
    }
}
