<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use \App\DataProvider\Eloquent\Customer;
use \App\DataProvider\Eloquent\Report;

class CustomerTest extends TestCase
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
    public function GET_api_customersにGETでアクセスできる()
    {
        $response = $this->get('/api/customers');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function GET_api_customersにGETでアクセスするとJSONが返却される()
    {
        $response = $this->get('/api/customers');
        $this->assertThat($response->content(), $this->isJson());
    }

    /**
     * @test
     */
    public function GET_api_customersにGETメソッドで取得できる顧客情報のJSON形式は要件通りである()
    {
        $response = $this->get('/api/customers');
        $customers = $response->json();
        $customer = $customers[0];
        $this->assertSame(['id', 'name'], array_keys($customer));
    }

    /**
     * @test
     */
    public function GET_api_customersにGETメソッドでアクセスすると2件の顧客リストが返却される()
    {
        $response = $this->get('/api/customers');
        $response->assertJsonCount(2);
    }

    /**
     * @test
     */
    public function POST_api_customersにPOSTメソッドでアクセスできる()
    {
        $customer = [
            'name' => 'customer_name'
        ];
        $response = $this->postJson('/api/customers', $customer);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function POST_api_customersに顧客名をPOSTするとcustomersテーブルにそのデータが追加される()
    {
        $params = [
            'name' => '顧客名'
        ];
        $this->postJson('api/customers', $params);
        $this->assertDatabaseHas('customers', $params);
    }

    /**
     * @test
     */
    public function POST_api_customersにnameが含まれない場合422UnprocessableEntityが返却される()
    {
        $params = [];
        $response = $this->postJson('api/customers', $params);
        $response->assertStatus(\Illuminate\Http\Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @test
     */
    public function POST_api_customersにnameが空の場合422UnprocessableEntityが返却される()
    {
        $params = [
            'name' => ''
        ];
        $response = $this->postJson('api/customers', $params);
        $response->assertStatus(\Illuminate\Http\Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @test
     */
    public function POST_api_customersのエラーレスポンスの確認()
    {
        $params = ['name' => ''];
        $response = $this->postJson('api/customers', $params);
        $error_response = [
            'message' => "The given data was invalid.",
            'errors' => [
                'name' => [
                    'name は必須項目です'
                ],
            ]
        ];
        $response->assertExactJson($error_response);
    }

    /**
     * @test
     */
    public function GET_api_customers_idにGETでアクセスできる()
    {
        $customer_id = $this->getFirstCustomerId();
        $response = $this->get('/api/customers/' . $customer_id);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function GET_api_customer_idに存在しないcustomer_idでGETメソッドでアクセスすると404が返却される()
    {
        $response = $this->get('/api/customers/99999999');
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /**
     * @test
     */
    public function GET_api_customers_idにGETでアクセスするとJSONが返却される()
    {
        $customer_id = $this->getFirstCustomerId();
        $response = $this->get('/api/customers/' . $customer_id);
        $this->assertThat($response->content(), $this->isJson());
    }

    /**
     * @test
     */
    public function PUT_api_customers_idにPUTでアクセスできる()
    {
        $params = [
            'name' => 'Update',
        ];
        $customer_id = $this->getFirstCustomerId();
        $response = $this->putJson('/api/customers/' . $customer_id, $params);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function PUT_api_customers_idにnameが含まれない場合422が返却される()
    {
        $params = [];
        $customer_id = $this->getFirstCustomerId();
        $response = $this->putJson('/api/customers/' . $customer_id, $params);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @test
     */
    public function PUT_api_customers_idにnameが空の場合422が返却される()
    {
        $params = [
            'name' => ''
        ];
        $customer_id = $this->getFirstCustomerId();
        $response = $this->putJson('/api/customers/' . $customer_id, $params);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @test
     */
    public function DELETE_api_customers_idにDELETEでアクセスできる()
    {
        $customer_id = $this->getFirstCustomerId();
        Report::query()->where('customer_id', $customer_id)->delete();
        $response = $this->delete('/api/customers/' . $customer_id);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function DELETE_api_customers_idに存在しないcustomer_idでアクセスすると404が返却される()
    {
        $response = $this->delete('/api/customers/999999999');
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /**
     * @test
     */
    public function DELETE_api_customers_idにReportが紐付いているcustomer_idでアクセスすると422が返却される()
    {
        $customer_id = $this->getFirstCustomerId();
        $response = $this->delete('/api/customers/' . $customer_id);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    private function getFirstCustomerId()
    {
        return Customer::query()->first()->value('id');
    }
}
