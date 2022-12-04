<?php

namespace Tests\Feature;

use App\Models\Customer;
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
        $response = HTTP::post('http://127.0.0.1:8000/api', $customer);

        $this->assertEquals(201, $response->json()['status']);

        $this->assertEquals(true, $response->successful());

        //$this->post('/api', $customer)->assertStatus(200);

    }

    /** @test */
    public function api_can_update_a_customer()
    {
        Customer::factory(2)->create();

        $this->withoutExceptionHandling();
        $customer = [
            'name' => 'new name',
            'address' => 'new address',
            'number' => '96103686512'
        ];
        //$response = HTTP::patch(route('customers.update', 1), $customer);
        //dd($response->json());
        //dd(route('customers.update', 3));
        $this->patch(route('customers.update', 1), $customer)->assertStatus(200);

         //$this->assertEquals(201, $response->json()['status']);

         //$this->assertEquals(true, $response->successful());
    }



}
