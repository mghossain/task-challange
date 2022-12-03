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
        $response = Http::get('http://127.0.0.1:8000/');

        $this->assertEquals(200, $response->json()['status']);

        $this->assertEquals(true, $response->successful());
    }
}
