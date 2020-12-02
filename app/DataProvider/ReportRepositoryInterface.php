<?php

declare(strict_types=1);

namespace App\DataProvider;

interface ReportRepositoryInterface
{
    public function getReports();

    public function addReport(array $params);

    public function exists($report_id);

    public function getReport($report_id);

    public function updateReport($report_id, array $params);

    public function deleteReport($report_id);

    public function hasReports($customer_id);
}
