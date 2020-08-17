<?php

use Illuminate\Database\Seeder;

class LoanFundingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\LoanFunding::class, 100)->create();
    }
}
