<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReportTest extends TestCase
{
    /**
     * @test
     */
    public function api_reportsにGETでアクセスできる()
    {
        $response = $this->get('/api/reports');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_reportsにPOSTでアクセスできる()
    {
        $response = $this->post('/api/reports');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_reports_idでGETにアクセスできる()
    {
        $response = $this->get('/api/reports/1');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_reports_idでPUTにアクセスできる()
    {
        $response = $this->put('/api/reports/1');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_reports_idでDELETEにアクセスできる()
    {
        $response = $this->delete('/api/reports/1');
        $response->assertStatus(200);
    }
}
