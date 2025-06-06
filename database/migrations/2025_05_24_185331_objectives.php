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
        Schema::create('objectives', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement()->primary();

            $table->string('name', 75);
            $table->decimal('target_amount', 10, 2)->unsigned();
            $table->decimal('current_amount', 10, 2)->unsigned()->default(0);
            $table->date('deadline')->nullable();
            $table->unsignedInteger('account_id');

            $table->boolean('enabled')->default(true);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();

            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade')->onUpdate('cascade');
        });
        Schema::create('objectives_operations', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement()->primary();

            $table->unsignedInteger('objective_id');
            $table->unsignedInteger('operation_id');

            $table->boolean('enabled')->default(true);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();

            $table->foreign('objective_id')->references('id')->on('objectives')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('operation_id')->references('id')->on('operations')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('objectives_operations');
        Schema::dropIfExists('objectives');

    }
};
