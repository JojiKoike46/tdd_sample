<?php

declare(strict_types=1);

namespace App\DataProvider;

interface CustomerRepositoryInterface
{
    public function getCustomers();

    public function addCustomer($name);

    public function exists($customer_id);

    public function getCustomer($customer_id);

    public function updateCustomer($customer_id, $name);

    public function deleteCustomer($customer_id);
}
