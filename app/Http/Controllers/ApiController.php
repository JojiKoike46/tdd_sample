<?php

namespace App\Http\Controllers;

use App\Services\CustomerService;
use App\Services\ReportService;
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

    public function getReports(ReportService $reportService)
    {
        return response()->json($reportService->getReports());
    }

    public function postReport(Request $request, ReportService $reportService)
    {
        $rules = [
            'visit_date' => 'required|date',
            'customer_id' => 'required|exists:customers,id',
            'detail' => 'required'
        ];
        $this->validate($request, $rules);
        $reportService->addReport($request->only('visit_date', 'customer_id', 'detail'));
    }

    public function getReport($report_id, ReportService $reportService)
    {
        if (!$reportService->exists($report_id)) {
            abort(Response::HTTP_NOT_FOUND);
        }
        return $reportService->getReport($report_id);
    }

    public function putReport($report_id, Request $request, ReportService $reportService)
    {
        if (!$reportService->exists($report_id)) {
            abort(Response::HTTP_NOT_FOUND);
        }
        $rules = [
            'visit_date' => 'required|date',
            'customer_id' => 'required|exists:customers,id',
            'detail' => 'required'
        ];
        $this->validate($request, $rules);
        $reportService->updateReport($report_id, $request->only('visit_date', 'customer_id', 'detail'));
    }

    public function deleteReport($report_id, ReportService $reportService)
    {
        if (!$reportService->exists($report_id)) {
            abort(Response::HTTP_NOT_FOUND);
        }
        $reportService->deleteReport($report_id);
    }
}
