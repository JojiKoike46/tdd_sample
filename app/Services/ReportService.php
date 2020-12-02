<?php

namespace App\Services;

use App\DataProvider\ReportRepositoryInterface;

class ReportService
{

    private $report;

    public function __construct(ReportRepositoryInterface $report)
    {
        $this->report = $report;
    }

    public function getReports()
    {
        return $this->report->getReports();
    }

    public function addReport(array $params)
    {
        $this->report->addReport($params);
    }

    public function getReport($report_id)
    {
        return $this->report->getReport($report_id);
    }

    public function updateReport($report_id, array $params)
    {
        $this->report->updateReport($report_id, $params);
    }

    public function deleteReport($report_id)
    {
        $this->report->deleteReport($report_id);
    }

    public function exists($report_id)
    {
        return $this->report->exists($report_id);
    }
}
