<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgrammedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('programmed')->insert([
            [
                'operation_id'    => 1,
                'expiration_date' => '2025-12-31',
                'period'          => 'm',
                'enabled'         => true
            ],
        ]);
    }
}
