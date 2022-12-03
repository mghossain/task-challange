<?php

namespace Tests\Feature;

use App\Models\Customer;
use GuzzleHttp\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function a_customer_can_be_created()
    {
        //$this->withoutExceptionHandling();

        $attributes = Customer::factory()->raw();

        $this->post('/', $attributes)->assertRedirect('/');

        $this->assertDatabaseHas('customers', $attributes);

        $this->get('/')->assertSee($attributes['name']);
    }

    /** @test */
    public function api_can_view_all_customers()
    {
        $response = Http::get('http://127.0.0.1:8000/api');

        $this->assertEquals(200, $response->json()['status']);

        $this->assertEquals(true, $response->successful());
    }

    /** @test */
    public function api_can_create_a_customer()
    {
        $customer = Customer::factory()->raw();
        // $customer = [
        //     'name' => 'michael gh',
        //     'address' => 'zah',
        //     'number' => '96171686512'
        // ];
        $response = Http::post('http://127.0.0.1:8000/api', $customer);

        $this->assertEquals(201, $response->json()['status']);

        $this->assertEquals(true, $response->successful());

        //$this->post('/api', $customer)->assertStatus(200);

    }


}
