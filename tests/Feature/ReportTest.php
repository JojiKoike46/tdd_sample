<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
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
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function api_reportsにGETでアクセスするとJSONが返却される()
    {
        $response = $this->get('/api/reports');
        $this->assertThat($response->content(), $this->isJson());
    }

    /**
     * @test
     */
    public function api_reportsにGETメソッドで取得できる顧客リストのJSON形式は要件通りである()
    {
        $response = $this->get('/api/reports');
        $reports = $response->json();
        $report = $reports[0];
        $this->assertSame(['id', 'visit_date', 'customer_id', 'detail'], array_keys($report));
    }

    /**
     * @test
     */
    public function api_reportsにGETメソッドでアクセスすると4件の訪問記録が取得できる()
    {
        $response = $this->get('/api/reports');
        $response->assertJsonCount(4);
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
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function api_reportsにPOSTでアクセスするとreportsテーブルにそのデータが追加される()
    {
        $customer_id = $this->getFirstCustomerId();
        $params = [
            'visit_date' => '2020-01-02',
            'customer_id' => $customer_id,
            'detail' => 'detail text'
        ];
        $this->postJson('/api/reports', $params);
        $this->assertDatabaseHas('reports', $params);
    }

    /**
     * @test
     */
    public function api_reportsに存在しないcustomer_idがPOSTされた場合422が返却される()
    {
        $params = [
            'visit_date' => '2020-01-01',
            'customer_id' => 999999999999,
            'detail' => 'detail text'
        ];
        $response = $this->postJson('/api/reports', $params);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @test
     * @dataProvider getInvalidDateParamsForPostReports
     */
    public function api_reportsにvisit_dateが不正な日付がPOSTされた場合422が返却される($params)
    {
        $this->replaceCustomerId($params);
        $response = $this->postJson('/api/reports', $params);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @test
     * @dataProvider getInvalidParamsForPostReports
     */
    public function api_reportsに必須データが無い入力がPOSTされた場合422が返却される($params)
    {
        $this->replaceCustomerId($params);
        $response = $this->postJson('/api/reports', $params);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }


    public function getInvalidDateParamsForPostReports()
    {
        $customer_id = 1;
        return [
            [
                ['visit_date' => 'aaa', 'customer_id' => $customer_id, 'detail' => 'detail text'],
            ],
            [
                ['visit_date' => '2018-02-29', 'customer_id' => $customer_id, 'detail' => 'detail text']
            ]
        ];
    }

    public function getInvalidParamsForPostReports()
    {
        $customer_id = 1;
        return [
            [
                ['visit_date' => '', 'customer_id' => '', 'detail' => ''],
            ],
            [
                ['visit_date' => '2018-09-01', 'customer_id' => '', 'detail' => ''],
            ],
            [
                ['visit_date' => '', 'customer_id' => $customer_id, 'detail' => ''],
            ],
            [
                ['visit_date' => '', 'customer_id' => '', 'detail' => 'detail text'],
            ],
            [
                ['visit_date' => '2018-09-01', 'customer_id' => $customer_id, 'detail' => ''],
            ],
            [
                ['visit_date' => '', 'customer_id' => $customer_id, 'detail' => 'detail text'],
            ],
            [
                ['visit_date' => '2018-09-01', 'customer_id' => '', 'detail' => 'detail text'],
            ],
        ];
    }

    private function replaceCustomerId(&$params)
    {
        $customer_id = $this->getFirstCustomerId();
        foreach ($params as $key => $param) {
            if (array_get($param, 'customer_id')) {
                $params[$key]['customer_id'] = $customer_id;
            }
        }
    }

    /**
     * @test
     */
    public function api_reports_idでGETにアクセスできる()
    {
        $reportId = $this->getFirstReportId();
        $response = $this->get('/api/reports/' . $reportId);
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function api_reports_report_idでPUTにアクセスできる()
    {
        $report_id = $this->getFirstReportId();
        $customer_id = $this->getFirstCustomerId();
        $params = [
            'visit_date' => '2020-11-30',
            'customer_id' => $customer_id,
            'detail' => 'detail text'
        ];
        $response = $this->putJson('/api/reports/' . $report_id, $params);
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function api_reports_report_idにPUTメソッドで訪問記録が編集できる()
    {
        $customer_id = $this->getFirstCustomerId();
        $report_id = $this->getFirstReportId();
        $response = $this->get('/api/reports/' . $report_id);
        $report = $response->json();
        $new_params = [
            'visit_date' => '1999-12-31',
            'customer_id' => $customer_id + 1,
            'detail' => $report['detail'] . '_new',
        ];
        $this->putJson('/api/reports/' . $report_id, $new_params);
        $response = $this->get('/api/reports/' . $report_id);
        $report = $response->json();

        $result = array_merge(['id' => $report_id], $new_params);
        $this->assertSame($result, $report);
    }

    /**
     * @test
     */
    public function api_reports_idに存在しないreport_idでPUTメソッドでアクセスすると404が返却される()
    {
        $customer_id = $this->getFirstCustomerId();
        $params = [
            'visit_date' => '2020-11-30',
            'customer_id' => $customer_id,
            'detail' => 'detail text'
        ];
        $response = $this->putJson('/api/reports/99999999', $params);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /**
     * @test
     */
    public function api_reports_idに存在しないcustomer_idでPUTメソッドでアクセスすると422が返却される()
    {
        $report_id = $this->getFirstReportId();
        $params = [
            'visit_date' => '2018-09-02',
            'customer_id' => 9999999999,
            'detail' => 'detail text'
        ];
        $response = $this->putJson('/api/reports/' . $report_id, $params);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @test
     * @dataProvider getInvalidDateParamsForPostReports
     */
    public function api_reports_idに不正なvisit_dateでPUTされた場合422が返却される($params)
    {
        $report_id = $this->getFirstReportId();
        $this->replaceCustomerId($params);
        $response = $this->putJson('/api/reports/' . $report_id);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @test
     * @dataProvider getInvalidParamsForPostReports
     */
    public function api_reports_idに必須入力が無いデータがPUTされた場合422が返却される($params)
    {
        $report_id = $this->getFirstReportId();
        $this->replaceCustomerId($params);
        $response = $this->putJson('/api/reports/' . $report_id, $params);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @test
     */
    public function api_reports_idでDELETEにアクセスできる()
    {
        $report_id = $this->getFirstReportId();
        $response = $this->delete('/api/reports/' . $report_id);
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function api_reports_idにDELETEメソッドで訪問記録が削除できる()
    {
        $report_id = $this->getFirstReportId();
        $this->delete('/api/reports/' . $report_id);
        $this->assertDatabaseMissing('reports', ['id' => $report_id]);
    }

    /**
     * @test
     */
    public function api_reports_idに存在しないreport_idでDELETEメソッドにアクセスすると404が返却される()
    {
        $response = $this->delete('/api/reports/999999999');
        $response->assertStatus(Response::HTTP_NOT_FOUND);
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
