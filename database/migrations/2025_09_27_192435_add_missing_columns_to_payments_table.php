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
        Schema::table('payments', function (Blueprint $table) {
            // Add payment_method_id column to link to payment_methods table
            $table->unsignedBigInteger('payment_method_id')->nullable()->after('transaction_id');
            $table->foreign('payment_method_id')->references('id')->on('payment_methods')->onDelete('set null');
            
            // Add payment_date column for when the payment was made
            $table->date('payment_date')->nullable()->after('amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Drop the foreign key constraint first
            $table->dropForeign(['payment_method_id']);
            
            // Drop the columns
            $table->dropColumn(['payment_method_id', 'payment_date']);
        });
    }
};
