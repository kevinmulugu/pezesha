<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\LoanFunding;
use Faker\Generator as Faker;

$factory->define(LoanFunding::class, function (Faker $faker) {
    return [
        'loan_id' => random_int(1, 20),
        'lender_id' => random_int(1, 10),
        'amount' => mt_rand (10, 70000),
    ];
});
