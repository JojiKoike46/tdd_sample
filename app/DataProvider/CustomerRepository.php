<?php

declare(strict_types=1);

namespace App\DataProvider;

use App\DataProvider\CustomerRepositoryInterface;
use \App\DataProvider\Eloquent\Customer;
use \App\DataProvider\Eloquent\Report;

class CustomerRepository implements CustomerRepositoryInterface
{
    public function getCustomers()
    {
        return Customer::query()->select(['id', 'name'])->get();
    }

    public function addCustomer($name)
    {
        $customer = new Customer();
        $customer->name = $name;
        $customer->save();
    }

    public function exists($customer_id)
    {
        return Customer::query()
            ->where('id', '=', $customer_id)->exists();
    }

    public function getCustomer($customer_id)
    {
        return Customer::query()
            ->where('id', '=', $customer_id)
            ->select(['id', 'name'])
            ->first();
    }

    public function updateCustomer($customer_id, $name)
    {
        $customer = Customer::query()->find($customer_id);
        $customer->name = $name;
        $customer->save();
    }

    public function deleteCustomer($customer_id)
    {
        Customer::query()->where('id', '=', $customer_id)->delete();
    }
}
