<?php

namespace Tests\Feature;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NumberValidationTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function a_customer_has_a_valid_number()
    {
        $this->withoutExceptionHandling();

        $attributes = Customer::factory()->raw();

        $this->post('/numvalidate', $attributes)->assertRedirect('/');

        $this->assertEquals($attributes['valid'], true);
    }

}
