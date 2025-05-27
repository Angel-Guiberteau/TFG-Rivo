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
        Schema::table('programmed', function (Blueprint $table) {
            $table->dropForeign(['operation_id']);
        });

        Schema::table('no_programmed', function (Blueprint $table) {
            $table->dropForeign(['operation_id']);
        });
        
        Schema::rename('programmed', 'operations_planned');
        Schema::rename('no_programmed', 'operations_unschedule');
        
        Schema::table('operations_planned', function (Blueprint $table) {
            $table->foreign('operation_id')
                ->references('id')
                ->on('operations')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::table('operations_unschedule', function (Blueprint $table) {
            $table->foreign('operation_id')
                ->references('id')
                ->on('operations')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });


        Schema::table('operations', function (Blueprint $table) {
            $table->renameColumn('categories_id', 'category_id');
            $table->decimal('amount', 10, 2)->unsigned()->after('description')->change();
            $table->char('type', 1)->after('amount')->change(); // i, e, s
        });

        Schema::table('operations_planned', function (Blueprint $table) {
            $table->date('start_date')->after('operation_id');
            $table->date('expiration_date')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('operations_planned', function (Blueprint $table) {
            $table->dropForeign(['operation_id']);
        });

        Schema::table('operations_unschedule', function (Blueprint $table) {
            $table->dropForeign(['operation_id']);
        });

        Schema::rename('operations_planned', 'programmed');
        Schema::rename('operations_unschedule', 'no_programmed');

        Schema::table('programmed', function (Blueprint $table) {
            $table->foreign('operation_id')
                ->references('id')
                ->on('operations')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::table('no_programmed', function (Blueprint $table) {
            $table->foreign('operation_id')
                ->references('id')
                ->on('operations')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::table('operations', function (Blueprint $table) {
            $table->renameColumn('category_id', 'categories_id');
            $table->decimal('amount', 10, 2)->unsigned()->change();
            $table->char('type', 1)->change();
        });

        Schema::table('programmed', function (Blueprint $table) {
            $table->dropColumn('start_date');
        });

        Schema::table('programmed', function (Blueprint $table) {
            $table->date('expiration_date')->nullable(false)->change();
        });
    }


};
