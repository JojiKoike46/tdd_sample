<?php

use Faker\Generator as Faker;
use App\DataProvider\Eloquent\Customer;

$factory->define(Customer::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
    ];
});
