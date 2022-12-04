<?php

namespace Tests\Feature;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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

        $response = $this->get(route('customers.index'));

        $this->assertEquals(200, $response->json()['status']);

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
        $responseMsg = $this->post(route('customers.store'), $customer)->json()['api'];

        $this->assertEquals("API Successful", $responseMsg);
    }

    /** @test */
    public function api_can_update_a_customer()
    {
        Customer::factory(2)->create();

        $this->withoutExceptionHandling();
        $customer = [
            'name' => 'new name',
            'address' => 'new address',
            'number' => '96171686515'
        ];
        dd(route('customers.index'), $customer);
        $responseMsg = $this->patch(route('customers.update', 1), $customer)->json()['api'];

        $this->assertEquals("API Successful", $responseMsg);
    }

    /** @test */
    public function api_customer_can_be_deleted()
    {
        Customer::factory(5)->create();

        $responseMsg = $this->delete(route('customers.destroy', 1))->json()['api'];
        //dd($responseMsg);
        $this->assertEquals("Customer deleted successfully" , $responseMsg);
    }

}
