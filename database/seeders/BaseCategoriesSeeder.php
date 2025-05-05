<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BaseCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('base_categories')->insert([
            [
                'categories_id' => 1,
                'enabled' => true
            ],
            [
                'categories_id' => 2,
                'enabled' => true
            ],
            [
                'categories_id' => 3,
                'enabled' => true
            ],
        ]);
    }
}
