<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('endpoints', function (Blueprint $table) {
            $table->unsignedTinyInteger('id')->autoIncrement()->primary();
            $table->string('name', 75);
            $table->string('url', 255);
            $table->string('method', 7);
            $table->string('parameters', 75)->nullable();;
            $table->string('return', 15);
            $table->text('description')->nullable();
            $table->boolean('enabled')->default(true);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
        });

        DB::table('endpoints')->insert([
            [
                'name' => 'GetOperationById',
                'url' => '/api/operation/transaction/{id}',
                'method' => 'GET',
                'parameters' => 'id:int',
                'return' => 'JsonResponse',
                'enabled' => true,
            ],
            [
                'name' => 'IncomeOperations',
                'url' => '/api/operation/incomeOperations',
                'method' => 'GET',
                'parameters' => 'offset:int',
                'return' => 'JsonResponse',
                'enabled' => true,
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('endpoints');
    }
};
