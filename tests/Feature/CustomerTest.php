<?php

namespace Tests\Feature;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;

class CustomerTest extends TestCase
{
    //use WithFaker, RefreshDatabase;

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
        Customer::factory(10)->create();

        $response = $this->get(route('customers.index'));

        $response->assertStatus(200);

    }

    /** @test */
    public function api_can_create_a_customer()
    {
        //$this->withoutExceptionHandling();
        //$customer = Customer::factory()->raw();
        //dd($customer);
        $customer = [
            'name' => 'michael ne',
            'address' => 'nza',
            'number' => '96103686517'
        ];
        $response = $this->post(route('customers.store'), $customer);
        $response->assertStatus(200);
        //dd($response);
        $this->assertDatabaseHas('customers', $customer);

    }

    /** @test */
    public function api_can_update_a_customer()
    {
        //Customer::factory(2)->create();

        $this->withoutExceptionHandling();
        $customer = [
            'name' => 'new namee',
            'address' => 'new ad',
            'number' => '9617515'
        ];
        //dd(route('customers.index'), $customer);
        //dd(route('customers.update', 5));
        $response = $this->patch(route('customers.update', 6), $customer);
        //dd($response);
        $response->assertStatus(200);

        $this->assertDatabaseHas('customers', $customer);
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
