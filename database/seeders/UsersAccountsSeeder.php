<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersAccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users_accounts')->insert([
            [
                'user_id'    => 2,
                'account_id' => 1,
                'enabled'    => true,
            ],
            [
                'user_id'    => 4,
                'account_id' => 2,
                'enabled'    => true,
            ],
            [
                'user_id'    => 2,
                'account_id' => 5,
                'enabled'    => true,
            ],
            [
                'user_id'    => 3,
                'account_id' => 3,
                'enabled'    => true,
            ],
            [
                'user_id'    => 5,
                'account_id' => 4,
                'enabled'    => true,
            ],
        ]);
    }
}
