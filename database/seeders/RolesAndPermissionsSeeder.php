<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // User permissions
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'user-show',

            // Role permissions
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'role-show',

            // Permission permissions
            'permission-list',
            'permission-create',
            'permission-edit',
            'permission-delete',
            'permission-show',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $superAdmin = Role::create(['name' => 'super-admin']);
        $admin = Role::create(['name' => 'admin']);
        $user = Role::create(['name' => 'user']);

        // Super Admin gets all permissions
        $superAdmin->givePermissionTo(Permission::all());

        // Admin gets all permissions except super-admin specific ones
        $admin->givePermissionTo([
            'user-list', 'user-create', 'user-edit', 'user-delete', 'user-show',
            'role-list', 'role-show',
            'permission-list', 'permission-show'
        ]);

        // User gets basic permissions
        $user->givePermissionTo([
            'user-show'
        ]);

        // Create a super admin user
        $superAdminUser = User::create([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'superadmin@example.com',
            'password' => bcrypt('password'),
            'phone' => '1234567890',
            'id_number' => 'SA001',
            'payment_status' => 'paid'
        ]);
        $superAdminUser->assignRole('super-admin');

        // Create an admin user
        $adminUser = User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'phone' => '1234567891',
            'id_number' => 'A001',
            'payment_status' => 'paid'
        ]);
        $adminUser->assignRole('admin');

        // Create a regular user
        $regularUser = User::create([
            'first_name' => 'Regular',
            'last_name' => 'User',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
            'phone' => '1234567892',
            'id_number' => 'U001',
            'payment_status' => 'pending'
        ]);
        $regularUser->assignRole('user');
    }
}
