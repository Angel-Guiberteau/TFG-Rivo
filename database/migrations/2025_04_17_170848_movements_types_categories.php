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
        Schema::create('movements_types_categories', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement()->primary();

            $table->unsignedInteger('movement_type_id');
            $table->foreign('movement_type_id')->references('id')->on('movements_types')->onDelete('cascade')->onUpdate('cascade');
            
            $table->unsignedInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movements_types_categories');
    }
};
