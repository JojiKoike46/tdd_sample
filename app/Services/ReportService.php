<?php

namespace App\Services;

use App\Report;
use App\Customer;

class ReportService
{
    public function getReports()
    {
        return Report::query()
            ->select(['id', 'visit_date', 'customer_id', 'detail'])
            ->get();
    }

    public function addReport(array $params)
    {
        $report = new Report();
        $report->visit_date = array_get($params, 'visit_date');
        $report->customer_id = array_get($params, 'customer_id');
        $report->detail = array_get($params, 'detail');
        $report->save();
    }

    public function getReport($report_id)
    {
        return Report::query()
            ->where('id', '=', $report_id)
            ->select(['id', 'visit_date', 'customer_id', 'detail'])
            ->first();
    }

    public function updateReport($report_id, array $params)
    {
        $report = Report::query()->find($report_id);
        $report->visit_date = array_get($params, 'visit_date');
        $report->customer_id = array_get($params, 'customer_id');
        $report->detail = array_get($params, 'detail');
        $report->save();
    }

    public function deleteReport($report_id)
    {
        Report::query()->where('id', '=', $report_id)->delete();
    }

    public function exists($report_id)
    {
        return Report::query()->where('id', '=', $report_id)->exists();
    }
}
