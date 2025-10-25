<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsAndStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run()
    {
        $now = Carbon::now();

        // ----------------------------
        // Permissions
        // ----------------------------
        $modules = [
            'authentication' => ['users', 'roles', 'permissions', 'model_has_roles', 'model_has_permissions', 'role_has_permissions', 'sessions', 'password_reset_tokens', 'notifications', 'audit_logs'],
            'organization' => ['organizations', 'organization_members', 'organization_leader_history'],
            'blogs' => ['blogs', 'blog_category', 'blog_categories', 'blog_tag', 'blog_tags'],
            'payments/finance' => ['payments', 'payment_methods', 'payment_histories', 'payment_history', 'payment_reminders', 'charges', 'transactions', 'donations', 'contributions', 'receipts', 'statuses'],
            'content/media' => ['banners', 'galleries', 'contacts', 'incidents', 'incident_images', 'jobs'],
            'system/cache/jobs' => ['cache', 'cache_locks', 'failed_jobs', 'job_batches', 'migrations', 'settings', 'user_activity_logs']
        ];

        $actions = ['create', 'read', 'update', 'delete'];

        foreach ($modules as $module => $entities) {
            foreach ($entities as $entity) {
                foreach ($actions as $action) {
                    // Skip unnecessary actions
                    if (
                        in_array($entity, ['sessions', 'audit_logs', 'password_reset_tokens', 'cache', 'cache_locks', 'failed_jobs', 'job_batches', 'migrations', 'user_activity_logs', 'settings'])
                        && in_array($action, ['create', 'update', 'delete'])
                    ) {
                        continue;
                    }

                    $permissionName = strtolower("$action-$entity");

                    // Only insert if it doesn't exist
                    if (!DB::table('permissions')->where('name', $permissionName)->where('guard_name', 'web')->exists()) {
                        DB::table('permissions')->insert([
                            'name' => $permissionName,
                            'guard_name' => 'web',
                            'created_at' => $now,
                            'updated_at' => $now,
                        ]);
                    }
                }
            }
        }

        // ----------------------------
        // Statuses
        // ----------------------------
        $statuses = [
            'general_status' => ['active', 'inactive'],
            'banner_status' => ['active', 'inactive'],
            'incident_status' => ['pending', 'completed', 'inactive'],
            'payment_status' => ['unpaid', 'paid', 'pending'],
            'organization_status' => ['general', 'active', 'inactive']
        ];

        foreach ($statuses as $type => $names) {
            foreach ($names as $name) {
                DB::table('statuses')->insert([
                    'name' => strtolower($name),
                    'type' => strtolower($type),
                    'created_by' => 1, // you can change this according to admin id
                    'updated_by' => null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }
}
