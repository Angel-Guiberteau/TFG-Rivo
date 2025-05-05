<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'Food',
                'enabled' => true
            ],
            [
                'name' => 'Transport',
                'enabled' => true
            ],
            [
                'name' => 'Health',
                'enabled' => true
            ],
            [
                'name' => 'Entertainment',
                'enabled' => true
            ],
            [
                'name' => 'Seguro del hogar',
                'enabled' => true
            ],
            [
                'name' => 'Seguro del coche',
                'enabled' => true
            ],
        ]);
    }
}
