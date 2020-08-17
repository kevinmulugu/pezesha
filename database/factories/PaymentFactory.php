<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Payment;
use Faker\Generator as Faker;

$factory->define(Payment::class, function (Faker $faker) {
    return [
        'loan_id' => random_int(1, 50),
        'transaction_id' => random_int(1, 50),
        'paymentscol' => $faker->creditCardType,
    ];
});
