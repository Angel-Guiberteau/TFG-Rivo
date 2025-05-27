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
        Schema::create('operations', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement()->primary();
            $table->string('subject');
            $table->string('description', 255);
            $table->decimal('amount', 10, 2)->unsigned();
            $table->char('type', 1); // i, e, s
            $table->date('action_date');
            $table->unsignedInteger('account_id');
            $table->unsignedInteger('category_id');
            
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
        
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('restrict')->onUpdate('cascade');
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operations');
    }
};
