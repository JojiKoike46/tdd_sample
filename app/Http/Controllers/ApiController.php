<?php

namespace App\Http\Controllers;

use App\Services\CustomerService;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getCustomers(CustomerService $customerService)
    {
        return response()->json($customerService->getCustomers());
    }

    public function postCustomer(Request $request, CustomerService $customerService)
    {
        $this->validate(
            $request,
            ['name' => 'required'],
        );
        $customerService->addCustomer($request->json('name'));
    }

    public function getCustomer($customer_id)
    {
        return response()->json(\App\Customer::find($customer_id));
    }

    public function putCustomer($customer_id, Request $request)
    {
    }

    public function deleteCustomer($customer_id)
    {
    }

    public function getReports()
    {
    }

    public function postReport()
    {
    }

    public function getReport($report_id)
    {
    }

    public function putReport($report_id, Request $request)
    {
    }

    public function deleteReport($report_id)
    {
    }
}
