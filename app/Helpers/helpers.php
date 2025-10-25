<?php

if (!function_exists('get_setting')) {
    /**
     * Get general website setting by key
     *
     * @param string $key The setting key (e.g., 'contact_phone', 'logo', 'address')
     * @param mixed $default Default value if setting not found
     * @return mixed
     */
    function get_setting($key, $default = null)
    {
        return \App\Helpers\GeneralHelper::getSetting($key, $default);
    }
}

if (!function_exists('get_phone')) {
    /**
     * Get phone number
     *
     * @return string
     */
    function get_phone()
    {
        return \App\Helpers\GeneralHelper::getPhone();
    }
}


if (!function_exists('get_description')) {
    /**
     * Get phone number
     *
     * @return string
     */
    function get_description()
    {
        return \App\Helpers\GeneralHelper::get_description();
    }
}

if (!function_exists('get_email')) {
    /**
     * Get email address
     *
     * @return string
     */
    function get_email()
    {
        return \App\Helpers\GeneralHelper::getEmail();
    }
}

if (!function_exists('get_address')) {
    /**
     * Get address
     *
     * @return string
     */
    function get_address()
    {
        return \App\Helpers\GeneralHelper::getAddress();
    }
}

if (!function_exists('get_logo')) {
    /**
     * Get logo
     *
     * @return string
     */
    function get_logo()
    {
        return \App\Helpers\GeneralHelper::getLogo();
    }
}

if (!function_exists('get_favicon')) {
    /**
     * Get favicon
     *
     * @return string
     */
    function get_favicon()
    {
        return \App\Helpers\GeneralHelper::getFavicon();
    }
}

if (!function_exists('get_static')) {
    /**
     * Get static data from a JSON file in resources/static/
     * Usage: get_static('about', 'vision')
     *
     * @param string $file The JSON file name (without .json)
     * @param string|null $key The key to retrieve (optional)
     * @return mixed|null
     */
    function get_static($file, $key = null)
    {
        return \App\Helpers\GeneralHelper::static($file, $key);
    }
}

if (!function_exists('debugUserPermissions')) {
    /**
     * Debug function to check user permissions and role permissions with map function
     * This function provides detailed information about user permissions and role permissions
     *
     * @param string|array $permissions Permission(s) to check
     * @return void
     */
    function debugUserPermissions($permissions)
    {
        $user = auth()->user();
        
        if (!$user) {
            dd([
                'error' => 'No authenticated user found',
                'permissions_checked' => $permissions
            ]);
        }

        // Get user's direct permissions
        $userDirectPermissions = $user->permissions->map(function($permission) {
            return [
                'id' => $permission->id,
                'name' => $permission->name,
                'guard_name' => $permission->guard_name,
                'created_at' => $permission->created_at,
                'updated_at' => $permission->updated_at
            ];
        });

        // Get user's roles with their permissions
        $userRoles = $user->roles->map(function($role) {
            return [
                'id' => $role->id,
                'name' => $role->name,
                'guard_name' => $role->guard_name,
                'permissions' => $role->permissions->map(function($permission) {
                    return [
                        'id' => $permission->id,
                        'name' => $permission->name,
                        'guard_name' => $permission->guard_name
                    ];
                })->toArray(),
                'created_at' => $role->created_at,
                'updated_at' => $role->updated_at
            ];
        });

        // Check if user has direct permissions
        $hasDirectPermissions = $userDirectPermissions->isNotEmpty();
        
        // Check permissions against user's direct permissions
        $directPermissionCheck = false;
        if ($hasDirectPermissions) {
            if (is_array($permissions)) {
                $directPermissionCheck = $user->permissions()->whereIn('name', $permissions)->exists();
            } else {
                $directPermissionCheck = $user->permissions()->where('name', $permissions)->exists();
            }
        }

        // Check permissions against role permissions
        $rolePermissionCheck = false;
        $matchingRoles = collect();
        
        foreach ($user->roles as $role) {
            if (is_array($permissions)) {
                if ($role->permissions()->whereIn('name', $permissions)->exists()) {
                    $rolePermissionCheck = true;
                    $matchingRoles->push([
                        'role_id' => $role->id,
                        'role_name' => $role->name,
                        'matching_permissions' => $role->permissions()->whereIn('name', $permissions)->pluck('name')->toArray()
                    ]);
                }
            } else {
                if ($role->permissions()->where('name', $permissions)->exists()) {
                    $rolePermissionCheck = true;
                    $matchingRoles->push([
                        'role_id' => $role->id,
                        'role_name' => $role->name,
                        'matching_permissions' => [$permissions]
                    ]);
                }
            }
        }

        // Final result based on the logic
        $finalResult = false;
        if ($hasDirectPermissions) {
            $finalResult = $directPermissionCheck;
        } else {
            $finalResult = $rolePermissionCheck;
        }

        $debugData = [
            'user_info' => [
                'id' => $user->id,
                'name' => $user->first_name . ' ' . $user->last_name,
                'email' => $user->email,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at
            ],
            'permissions_checked' => $permissions,
            'user_direct_permissions' => $userDirectPermissions->toArray(),
            'has_direct_permissions' => $hasDirectPermissions,
            'direct_permission_check' => $directPermissionCheck,
            'user_roles' => $userRoles->toArray(),
            'role_permission_check' => $rolePermissionCheck,
            'matching_roles' => $matchingRoles->toArray(),
            'final_result' => $finalResult,
            'permission_logic' => $hasDirectPermissions ? 
                'User has direct permissions - only checking direct permissions' : 
                'User has no direct permissions - checking role permissions'
        ];

        dd($debugData);
    }
}

if (!function_exists('hasPermissionOrRole')) {
    /**
     * Check if user has permission or role permission
     * First checks direct user permissions, then falls back to role permissions
     * Only checks role permissions if user has NO direct permissions
     *
     * @param string|array $permissions Permission(s) to check
     * @return bool
     */
    function hasPermissionOrRole($permissions)
    {
        $user = auth()->user();
        
        // First, check if user has the permission directly
        if (is_array($permissions)) {
            // Check if user has any of these permissions directly
            $hasDirectPermission = $user->permissions()->whereIn('name', $permissions)->exists();
        } else {
            // Check if user has this specific permission directly
            $hasDirectPermission = $user->permissions()->where('name', $permissions)->exists();
        }
        
        // If user has direct permission, return true
        if ($hasDirectPermission) {
            return true;
        }
        
        // If no direct permission, check role permissions
        if (is_array($permissions)) {
            // Check if any of the user's roles has any of the required permissions
            foreach ($user->roles as $role) {
                if ($role->permissions()->whereIn('name', $permissions)->exists()) {
                    return true;
                }
            }
        } else {
            // Check if any of the user's roles has the required permission
            foreach ($user->roles as $role) {
                if ($role->permissions()->where('name', $permissions)->exists()) {
                    return true;
                }
            }
        }
        
        return false;
    }
}
