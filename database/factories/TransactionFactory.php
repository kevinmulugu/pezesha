<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Transaction;
use Faker\Generator as Faker;

$factory->define(Transaction::class, function (Faker $faker) {
    return [
        'customer_id' => random_int(1, 50),
        'amount' =>  mt_rand (10, 70000),
        'reference' => $faker->swiftBicNumber,
        'time' => now()->subDays(random_int(1, 90))
    ];
});
