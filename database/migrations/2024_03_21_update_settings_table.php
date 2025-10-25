<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            // Add any missing columns
            if (!Schema::hasColumn('settings', 'group')) {
                $table->string('group')->default('general')->after('value');
            }
            if (!Schema::hasColumn('settings', 'type')) {
                $table->string('type')->default('text')->after('group');
            }
            if (!Schema::hasColumn('settings', 'is_required')) {
                $table->boolean('is_required')->default(false)->after('type');
            }
            if (!Schema::hasColumn('settings', 'created_by')) {
                $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            }
            if (!Schema::hasColumn('settings', 'updated_by')) {
                $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            }
        });

        // Insert default settings if they don't exist
        $settings = [
            // General Settings
            ['key' => 'site_name', 'value' => 'Wahfy', 'group' => 'general', 'type' => 'text', 'is_required' => true],
            ['key' => 'site_description', 'value' => '', 'group' => 'general', 'type' => 'textarea', 'is_required' => false],
            ['key' => 'contact_email', 'value' => '', 'group' => 'general', 'type' => 'email', 'is_required' => true],
            ['key' => 'contact_phone', 'value' => '', 'group' => 'general', 'type' => 'text', 'is_required' => false],
            ['key' => 'address', 'value' => '', 'group' => 'general', 'type' => 'textarea', 'is_required' => false],

            // System Settings
            ['key' => 'currency', 'value' => 'USD', 'group' => 'system', 'type' => 'text', 'is_required' => true],
            ['key' => 'currency_symbol', 'value' => '$', 'group' => 'system', 'type' => 'text', 'is_required' => true],
            ['key' => 'timezone', 'value' => 'UTC', 'group' => 'system', 'type' => 'select', 'is_required' => true],
            ['key' => 'date_format', 'value' => 'Y-m-d', 'group' => 'system', 'type' => 'select', 'is_required' => true],
            ['key' => 'time_format', 'value' => '24', 'group' => 'system', 'type' => 'select', 'is_required' => true],

            // Media Settings
            ['key' => 'logo', 'value' => '', 'group' => 'media', 'type' => 'file', 'is_required' => false],
            ['key' => 'favicon', 'value' => '', 'group' => 'media', 'type' => 'file', 'is_required' => false],
        ];

        foreach ($settings as $setting) {
            if (!DB::table('settings')->where('key', $setting['key'])->exists()) {
                DB::table('settings')->insert([
                    'key' => $setting['key'],
                    'value' => $setting['value'],
                    'group' => $setting['group'],
                    'type' => $setting['type'],
                    'is_required' => $setting['is_required'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['group', 'type', 'is_required']);
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
            $table->dropColumn(['created_by', 'updated_by']);
        });
    }
};
