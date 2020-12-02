<?php

use Faker\Generator as Faker;
use App\DataProvider\Eloquent\Report;

$factory->define(Report::class, function (Faker $faker) {
    return [
        'visit_date' => $faker->date(),
        'detail' => $faker->realText(),
    ];
});
