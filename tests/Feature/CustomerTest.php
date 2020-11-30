<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerTest extends TestCase
{
    /**
     * @test
     */
    public function api_customersにGETでアクセスできる()
    {
        $response = $this->get('/api/customers');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_customersにPOSTでアクセスできる()
    {
        $response = $this->post('/api/customers');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_customers_idにGETでアクセスできる()
    {
        $response = $this->get('/api/customers/1');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_customers_idにPUTでアクセスできる()
    {
        $response = $this->put('/api/customers/1');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_customers_idにDELETEでアクセスできる()
    {
        $response = $this->delete('/api/customers/1');
        $response->assertStatus(200);
    }
}
