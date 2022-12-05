<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;

class NumberValidationTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function a_customer_has_a_valid_number()
    {
        $this->withoutExceptionHandling();

        $data = ['number' => '96171686515'];
        //dd($data);
        //$this->post('http://127.0.0.1:8000/numvalidate', $data);
        $response = Http::post('http://localhost:8000/numvalidate', $data);
        //dd($response->body());
        $response = json_decode($response->body());


        assertEquals($data['number'], $response->number);

    }


}
