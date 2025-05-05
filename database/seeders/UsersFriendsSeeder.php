<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersFriendsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users_friends')->insert([
            [
                'sender_id'  => 1,
                'receiver_id'=> 2,
                'status'     => 'A',
                'enabled'    => true
            ],
            [
                'sender_id'  => 3,
                'receiver_id'=> 1,
                'status'     => 'P',
                'enabled'    => true
            ],
        ]);
    }
}
