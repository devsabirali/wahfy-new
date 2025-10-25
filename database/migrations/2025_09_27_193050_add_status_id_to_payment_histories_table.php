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
        Schema::table('payment_histories', function (Blueprint $table) {
            // Add status_id column to link to statuses table
            $table->unsignedBigInteger('status_id')->nullable()->after('transaction_id');
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_histories', function (Blueprint $table) {
            // Drop the foreign key constraint first
            $table->dropForeign(['status_id']);
            
            // Drop the column
            $table->dropColumn('status_id');
        });
    }
};
