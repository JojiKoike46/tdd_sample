<?php

namespace App\Http\Controllers;

use App\Services\CustomerService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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

    public function getCustomer($customer_id, CustomerService $customerService)
    {
        if (!$customerService->exists($customer_id)) {
            abort(Response::HTTP_NOT_FOUND);
        }
        return response()->json($customerService->getCustomer($customer_id));
    }

    public function putCustomer($customer_id, Request $request, CustomerService $customerService)
    {
        if (!$customerService->exists($customer_id)) {
            abort(Response::HTTP_NOT_FOUND);
        }
        $this->validate(
            $request,
            ['name' => 'required']
        );
        $customerService->updateCustomer($customer_id, $request->json('name'));
    }

    public function deleteCustomer($customer_id, CustomerService $customerService)
    {
        if (!$customerService->exists($customer_id)) {
            abort(Response::HTTP_NOT_FOUND);
        }
        if ($customerService->hasReports($customer_id)) {
            abort(Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $customerService->deleteCustomer($customer_id);
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
