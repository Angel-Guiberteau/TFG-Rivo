<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NoProgrammedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('no_programmed')->insert([
            [
                'operation_id' => 2,
                'enabled'      => true
            ],
        ]);
    }
}
