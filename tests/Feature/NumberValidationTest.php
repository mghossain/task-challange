<?php

namespace Tests\Feature;

use App\Services\NumValidation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NumberValidationTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function a_customer_has_a_valid_number()
    {
        $number = fake()->e164PhoneNumber;

        $validatedResponse = (new NumValidation())->numberValidation($number);

        $this->assertEquals($validatedResponse->valid, true);
    }


}
