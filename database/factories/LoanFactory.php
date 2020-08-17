<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Loan;
use Faker\Generator as Faker;

$factory->define(Loan::class, function (Faker $faker) {
    return [
        'customer_id' => random_int(1, 50),
        'amount' => mt_rand (10, 70000),
        'status' => random_int(1,20) > 10 ? 'Pending' : 'Processed',
    ];
});
