<?php

use Illuminate\Database\Seeder;

class CustomersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Customer::class, 50)->create()->each(function ($customer) {
            $customer->loans()->save(factory(App\Loan::class)->make());
            $customer->transactions()->save(factory(App\Transaction::class)->make());
        });
    }
}
