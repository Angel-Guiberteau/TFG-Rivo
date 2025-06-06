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
            $table->string('return_data', 255);
            $table->string('description', 255)->nullable();
            $table->boolean('enabled')->default(true);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
        });

        DB::table('endpoints')->insert([
            [
                'name' => 'GetOperationById',
                'url' => '/api/operation/transaction/{id}',
                'method' => 'GET',
                'parameters' => "[id : int]",
                'return' => 'JsonResponse',
                'return_data' => "['id' int]",
                'enabled' => true,
            ],
            [
                'name' => 'IncomeOperations',
                'url' => '/api/operation/incomeOperations',
                'method' => 'GET',
                'parameters' => "[offset : int]",
                'return' => 'JsonResponse',
                'return_data' => "['incomes' Collection]",
                'enabled' => true,
            ],
            [
                'name' => 'ExpenseOperations',
                'url' => '/api/operation/expenseOperations',
                'method' => 'GET',
                'parameters' => "[offset : int]",
                'return' => 'JsonResponse',
                'return_data' => "['expenses' Collection]",
                'enabled' => true,
            ],
            [
                'name' => 'SaveOperations',
                'url' => '/api/operation/saveOperations',
                'method' => 'GET',
                'parameters' => "[offset : int]",
                'return' => 'JsonResponse',
                'return_data' => "['expenses' Collection]",
                'enabled' => true,
            ],
            [
                'name' => 'GetAllOperations',
                'url' => '/api/operation/getAllOperations',
                'method' => 'GET',
                'parameters' => "[offset : int | limit : int]",
                'return' => 'JsonResponse',
                'return_data' => "['operations' Collection]",
                'enabled' => true,
            ],
            [
                'name' => 'DeleteOperation',
                'url' => '/api/operation/deleteOperation/{id}',
                'method' => 'POST',
                'parameters' => "[id : int]",
                'return' => 'JsonResponse',
                'return_data' => "['success' string | 'error' string]",
                'enabled' => true,
            ],
            [
                'name' => 'RefreshRecentOperations',
                'url' => '/api/operation/refreshRecentOperations',
                'method' => 'GET',
                'parameters' => "[active_account_id : int]",
                'return' => 'JsonResponse',
                'return_data' => "['operation' collection]",
                'enabled' => true,
            ],
            [
                'name' => 'GetAllIcons',
                'url' => '/api/icon/getAllIcons',
                'method' => 'GET',
                'parameters' => " ",
                'return' => 'array',
                'return_data' => "['icons' array]",
                'enabled' => true,
            ],
            [
                'name' => 'DeleteObjective',
                'url' => '/api/objective/deleteObjective/{id}',
                'method' => 'POST',
                'parameters' => "[id : int]",
                'return' => 'JsonResponse',
                'return_data' => "['success' string | 'error' string]",
                'enabled' => true,
            ],
            [
                'name' => 'GetObjective',
                'url' => '/api/objective/getObjective/{id}',
                'method' => 'GET',
                'parameters' => "[id : int]",
                'return' => 'JsonResponse',
                'return_data' => "['objetive' Objective]",
                'enabled' => true,
            ],
            [
                'name' => 'DeleteCategoryUser',
                'url' => '/api/category/delete/{id}',
                'method' => 'POST',
                'parameters' => "[id : int]",
                'return' => 'JsonResponse',
                'return_data' => "['success' string | 'error' string]",
                'enabled' => true,
            ],
            [
                'name' => 'GetCategory',
                'url' => '/api/category/getCategory/{id}',
                'method' => 'GET',
                'parameters' => "[id : int]",
                'return' => 'Category|JsonResponse',
                'return_data' => "['category' Category | 'error' string]",
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
