<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Customer;
use App\Report;

class ReportTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        $this->artisan('db:seed', ['--class' => 'TestDataSeeder']);
    }

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
        $customerId = $this->getFirstCustomerId();
        $params = [
            'visit_date' => '2020-01-01',
            'customer_id' => $customerId,
            'detail' => 'detail text'
        ];
        $response = $this->postJson('/api/reports', $params);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_reports_idでGETにアクセスできる()
    {
        $reportId = $this->getFirstReportId();
        $response = $this->get('/api/reports/' . $reportId);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_reports_idでPUTにアクセスできる()
    {
        $report_id = $this->getFirstReportId();
        $customer_id = $this->getFirstCustomerId();
        $params = [
            'visit_date' => '2020-11-30',
            'customer_id' => $customer_id,
            'detail' => 'detail text'
        ];
        $response = $this->putJson('/api/reports/' . $report_id, $params);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_reports_idでDELETEにアクセスできる()
    {
        $report_id = $this->getFirstReportId();
        $response = $this->delete('/api/reports/' . $report_id);
        $response->assertStatus(200);
    }

    private function getFirstCustomerId()
    {
        return Customer::query()->first()->value('id');
    }

    private function getFirstReportId()
    {
        return Report::query()->first()->value('id');
    }
}
