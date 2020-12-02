<?php

namespace App\Services;

use App\DataProvider\CustomerRepositoryInterface;
use App\DataProvider\ReportRepositoryInterface;

class CustomerService
{

    private $customer;
    private $report;

    public function __construct(
        CustomerRepositoryInterface $customer,
        ReportRepositoryInterface $report
    ) {
        $this->customer = $customer;
        $this->report = $report;
    }

    public function getCustomers()
    {
        return $this->customer->getCustomers();
    }

    public function addCustomer($name)
    {
        $this->customer->addCustomer($name);
    }

    public function getCustomer($customer_id)
    {
        return $this->customer->getCustomer($customer_id);
    }

    public function exists($customer_id)
    {
        return $this->customer->exists($customer_id);
    }

    public function updateCustomer($customer_id, $name)
    {
        $this->customer->updateCustomer($customer_id, $name);
    }

    public function deleteCustomer($customer_id)
    {
        $this->customer->deleteCustomer($customer_id);
    }

    public function hasReports($customer_id)
    {
        return $this->report->hasReports($customer_id);
    }
}
