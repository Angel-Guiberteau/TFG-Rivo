<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user_categories')->insert([
            [
                'user_id' => 4,
                'categories_id' => 4,
                'enabled' => true
            ],
            [
                'user_id' => 4,
                'categories_id' => 5,
                'enabled' => true
            ],
            [
                'user_id' => 5,
                'categories_id' => 6,
                'enabled' => true
            ],
        ]);
    }
}
