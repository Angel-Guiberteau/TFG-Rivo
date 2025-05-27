<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('movements_types')->insert([
            [
                'name' => 'Income',
                'enabled' => true,
            ],
            [
                'name' => 'Expense',
                'enabled' => true,
            ],
            [
                'name' => 'Save money',
                'enabled' => true,
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('movements_types')->whereIn('id', [1, 2, 3])->delete();
    }
};
