<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OperationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('operations')->insert([
            [
                'subject'        => 'Grocery Shopping',
                'description'    => 'Bought groceries at local store',
                'action_date'    => '2024-04-10',
                'account_id'     => 1,
                'categories_id'  => 1,
                'enabled'        => true
            ],
            [
                'subject'        => 'Bus Ticket',
                'description'    => 'Monthly bus pass',
                'action_date'    => '2024-04-15',
                'account_id'     => 2,
                'categories_id'  => 2,
                'enabled'        => true
            ],
        ]);
    }
}
