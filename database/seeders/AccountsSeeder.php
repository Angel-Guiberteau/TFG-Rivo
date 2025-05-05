<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('accounts')->insert([
            [
                'name'       => 'Main Account',
                'balance'    => 1500.00,
                'currency'   => 'USD',
                'enabled'    => true,
            ],
            [
                'name'       => 'Savings',
                'balance'    => 10200.50,
                'currency'   => 'EUR',
                'enabled'    => true,
            ],
            [
                'name'       => 'Crypto Wallet',
                'balance'    => 3400.75,
                'currency'   => 'USD',
                'enabled'    => true,
            ],
            [
                'name'       => 'Vacation Fund',
                'balance'    => 850.00,
                'currency'   => 'GBP',
                'enabled'    => true,
            ],
            [
                'name'       => 'Vacations',
                'balance'    => 985.00,
                'currency'   => 'GBP',
                'enabled'    => true,
            ],
        ]);
    }
}
