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
        Schema::table('users', function (Blueprint $table) {
            // Split name into components
            $table->string('first_name')->after('name');
            $table->string('middle_name')->nullable()->after('first_name');
            $table->string('last_name')->after('middle_name');

            // Add new fields
            $table->string('phone')->after('email');
            $table->string('id_number')->unique()->after('phone');
            $table->string('payment_status')->default('pending')->after('id_number');
            $table->string('group_leader')->nullable()->after('payment_status');
            $table->string('group_name')->nullable()->after('group_leader');
            $table->string('family_leader')->nullable()->after('group_name');
            $table->string('family_name')->nullable()->after('family_leader');

            // Drop the original name column
            $table->dropColumn('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Recreate the name column
            $table->string('name')->after('id');

            // Drop all added columns
            $table->dropColumn([
                'first_name',
                'middle_name',
                'last_name',
                'phone',
                'id_number',
                'payment_status',
                'group_leader',
                'group_name',
                'family_leader',
                'family_name'
            ]);
        });
    }
};
