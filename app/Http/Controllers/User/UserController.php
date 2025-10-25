<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth; 

class UserController extends Controller
{
    public function __construct()
    {
        // $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index', 'show']]);
        // $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        // $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $currentUser = auth()->user();
        $query = User::with(['roles', 'permissions']);

        // Role-based filtering
        if ($currentUser->hasRole('admin')) {
            // Admin can see all users
            $users = $query->latest()->paginate(10);
        } elseif ($currentUser->hasRole('family leader')) {
            // Family leader can only see their family members
            $users = $query->where('family_leader', $currentUser->id)
                          ->orWhere('id', $currentUser->id) // Include themselves
                          ->latest()
                          ->paginate(10);
        } elseif ($currentUser->hasRole('group leader')) {
            // Group leader can only see their group members
            $users = $query->where('group_leader', $currentUser->id)
                          ->orWhere('id', $currentUser->id) // Include themselves
                          ->latest()
                          ->paginate(10);
        } else {
            // Other roles can only see themselves
            $users = $query->where('id', $currentUser->id)
                          ->latest()
                          ->paginate(10);
        }

        return view('admin.user-management.user.index', compact('users'))
            ->with('i', ($request->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $currentUser = auth()->user();
        
        // Role restrictions based on current user
        if ($currentUser->hasRole('admin')) {
            $roles = Role::pluck('name', 'id')->all();
        } else {
            // Leaders can only create members
            $memberRole = Role::where('name', 'member')->first();
            $roles = $memberRole ? [$memberRole->id => $memberRole->name] : [];
        }
        
        $permissions = Permission::all()->groupBy(function($permission) {
            $parts = explode('-', $permission->name);
            return end($parts); // Get the last part as module name (e.g., 'user' from 'create-user')
        })->map(function($modulePermissions) {
            $actions = ['create', 'read', 'update', 'delete'];
            $permissionMap = $modulePermissions->mapWithKeys(function($permission) {
                $parts = explode('-', $permission->name);
                $action = $parts[0]; // Get the first part as action (e.g., 'create' from 'create-user')
                return [$action => $permission->id];
            })->toArray();

            // Ensure all actions exist
            foreach ($actions as $action) {
                if (!isset($permissionMap[$action])) {
                    $permissionMap[$action] = null;
                }
            }

            return $permissionMap;
        });
        
        // Permission restrictions based on current user
        if (!$currentUser->hasRole('admin')) {
            // Leaders can only assign member permissions
            $memberPermissions = Permission::where('name', 'like', '%member%')->pluck('id')->toArray();
            $permissions = $permissions->map(function($modulePermissions) use ($memberPermissions) {
                return array_map(function($permissionId) use ($memberPermissions) {
                    return in_array($permissionId, $memberPermissions) ? $permissionId : null;
                }, $modulePermissions);
            });
        }
        
        $organizations = \App\Models\Organization::where('leader_id',Auth::user()->id)->get();
        return view('admin.user-management.user.create', compact('roles', 'permissions', 'organizations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required',
            'id_number' => 'required|unique:users,id_number',
            'password' => 'required|same:confirm-password',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
            'permissions' => 'nullable|string',
            'organization_id' => 'nullable|exists:organizations,id',
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $input['name'] = $input['first_name'] . ' ' . $input['last_name'];

        $user = User::create([
            'first_name' => $input['first_name'],
            'middle_name' => $input['middle_name'] ?? null,
            'last_name' => $input['last_name'],
            'email' => $input['email'],
            'phone' => $input['phone'],
            'id_number' => $input['id_number'],
            'password' => $input['password'],
            'payment_status' => $input['payment_status'] ?? 'pending',
            'group_leader' => $input['group_leader'] ?? null,
            'group_name' => $input['group_name'] ?? null,
            'family_leader' => $input['family_leader'] ?? null,
            'family_name' => $input['family_name'] ?? null,
            'organization_id' => $input['organization_id'] ?? null,
        ]);

        // Get role IDs and verify they exist
        $roleIds = array_map('intval', $request->input('roles', []));
        $existingRoles = Role::whereIn('id', $roleIds)->get();

        if ($existingRoles->isNotEmpty()) {
            $user->syncRoles($existingRoles);
        }

        // Handle permissions
        $permissionIds = json_decode($request->input('permissions', '[]'), true) ?? [];
        $permissionIds = array_map('intval', $permissionIds);

        // Get existing permissions
        $existingPermissions = Permission::whereIn('id', $permissionIds)->get();

        // Sync permissions
        $user->syncPermissions($existingPermissions);

        // Add to organization_members if role is 'member' and organization_id is provided
        $memberRole = Role::where('name', 'member')->first();
        if ($memberRole && in_array($memberRole->id, $roleIds) && $request->organization_id) {
            $activeStatus = \App\Models\Status::where('type', 'organization_status')
                ->where('name', 'active')
                ->first();
            
            \App\Models\OrganizationMember::create([
                'user_id' => $user->id,
                'organization_id' => $request->organization_id,
                'status_id' => $activeStatus->id ?? 1,
                'membership_start_date' => now(),
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
            ]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $currentUser = auth()->user();
        $user = User::with(['roles', 'permissions'])->findOrFail($id);

        // Check if current user has permission to view this user
        if (!$currentUser->hasRole('admin')) {
            if ($currentUser->hasRole('family leader')) {
                // Family leader can only view their family members
                if ($user->family_leader != $currentUser->id && $user->id != $currentUser->id) {
                    abort(403, 'You can only view your family members.');
                }
            } elseif ($currentUser->hasRole('group leader')) {
                // Group leader can only view their group members
                if ($user->group_leader != $currentUser->id && $user->id != $currentUser->id) {
                    abort(403, 'You can only view your group members.');
                }
            } else {
                // Other roles can only view themselves
                if ($user->id != $currentUser->id) {
                    abort(403, 'You can only view your own profile.');
                }
            }
        }

        return view('admin.user-management.user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        // Load user with relationships
        $user = User::with(['roles', 'permissions'])->findOrFail($id);
        $currentUser = auth()->user();

        // Check if current user has permission to edit this user
        if (!$currentUser->hasRole('admin')) {
            if ($currentUser->hasRole('family leader')) {
                // Family leader can only edit their family members
                if ($user->family_leader != $currentUser->id && $user->id != $currentUser->id) {
                    abort(403, 'You can only edit your family members.');
                }
            } elseif ($currentUser->hasRole('group leader')) {
                // Group leader can only edit their group members
                if ($user->group_leader != $currentUser->id && $user->id != $currentUser->id) {
                    abort(403, 'You can only edit your group members.');
                }
            } else {
                // Other roles can only edit themselves
                if ($user->id != $currentUser->id) {
                    abort(403, 'You can only edit your own profile.');
                }
            }
        }

        // Role restrictions based on current user
        if ($currentUser->hasRole('admin')) {
            $roles = Role::all()->pluck('name', 'id');
        } else {
            // Leaders can only assign member role
            $memberRole = Role::where('name', 'member')->first();
            $roles = $memberRole ? [$memberRole->id => $memberRole->name] : [];
        }

        // Get user's current roles and permissions
        $userRoles = $user->roles->pluck('id')->toArray();
        $userPermissions = $user->permissions->pluck('id')->toArray();

        // Group permissions by module and map their actions
        $permissions = Permission::all()->groupBy(function($permission) {
            $parts = explode('-', $permission->name);
            return end($parts); // Get the last part as module name (e.g., 'user' from 'create-user')
        })->map(function($modulePermissions) {
            return $modulePermissions->mapWithKeys(function($permission) {
                $parts = explode('-', $permission->name);
                $action = $parts[0]; // Get the first part as action (e.g., 'create' from 'create-user')
                return [$action => $permission->id];
            })->toArray();
        });

        // Permission restrictions based on current user
        if (!$currentUser->hasRole('admin')) {
            // Leaders can only assign member permissions
            $memberPermissions = Permission::where('name', 'like', '%member%')->pluck('id')->toArray();
            $permissions = $permissions->map(function($modulePermissions) use ($memberPermissions) {
                return array_map(function($permissionId) use ($memberPermissions) {
                    return in_array($permissionId, $memberPermissions) ? $permissionId : null;
                }, $modulePermissions);
            });
        }

        // Calculate which modules have all permissions checked
        $modulePermissionsChecked = $permissions->map(function($modulePermissions, $module) use ($userPermissions) {
            $modulePermissionIds = collect($modulePermissions)->filter()->values()->toArray();
            return !empty($modulePermissionIds) && empty(array_diff($modulePermissionIds, $userPermissions));
        })->toArray();

        $organizations = \App\Models\Organization::where('leader_id',Auth::user()->id)->get();

        return view('admin.user-management.user.edit', compact(
            'user',
            'roles',
            'permissions',
            'userRoles',
            'userPermissions',
            'modulePermissionsChecked',
            'organizations'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'phone' => 'required',
            'id_number' => 'required|unique:users,id_number,'.$id,
            'password' => 'nullable|same:confirm-password',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
            'permissions' => 'nullable|string',
            'organization_id' => 'nullable|exists:organizations,id',
        ]);

        // Find user
        $user = User::findOrFail($id);
        $currentUser = auth()->user();

        // Check if current user has permission to update this user
        if (!$currentUser->hasRole('admin')) {
            if ($currentUser->hasRole('family leader')) {
                // Family leader can only update their family members
                if ($user->family_leader != $currentUser->id && $user->id != $currentUser->id) {
                    abort(403, 'You can only update your family members.');
                }
            } elseif ($currentUser->hasRole('group leader')) {
                // Group leader can only update their group members
                if ($user->group_leader != $currentUser->id && $user->id != $currentUser->id) {
                    abort(403, 'You can only update your group members.');
                }
            } else {
                // Other roles can only update themselves
                if ($user->id != $currentUser->id) {
                    abort(403, 'You can only update your own profile.');
                }
            }
        }

        // Prepare user data
        $userData = [
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name ?? $user->middle_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'id_number' => $request->id_number,
            'payment_status' => $request->payment_status ?? $user->payment_status,
            'group_leader' => $request->group_leader ?? $user->group_leader,
            'group_name' => $request->group_name ?? $user->group_name,
            'family_leader' => $request->family_leader ?? $user->family_leader,
            'family_name' => $request->family_name ?? $user->family_name,
            'organization_id' => $request->organization_id ?? $user->organization_id,
        ];

        // Update password if provided
        if (!empty($request->password)) {
            $userData['password'] = Hash::make($request->password);
        }

        // Update user
        $user->update($userData);

        // Get role IDs and verify they exist
        $roleIds = array_map('intval', $request->input('roles', []));
        $existingRoles = Role::whereIn('id', $roleIds)->get();

        if ($existingRoles->isNotEmpty()) {
            $user->syncRoles($existingRoles);
        }

        // Handle permissions
        $permissionIds = json_decode($request->input('permissions', '[]'), true) ?? [];
        $permissionIds = array_map('intval', $permissionIds);

        // Get existing permissions
        $existingPermissions = Permission::whereIn('id', $permissionIds)->get();

        // Sync permissions
        $user->syncPermissions($existingPermissions);

        // Handle organization membership
        $memberRole = Role::where('name', 'member')->first();
        $isMember = $memberRole && in_array($memberRole->id, $roleIds);
        
        if ($isMember && $request->organization_id) {
            // Add or update organization membership
            $activeStatus = \App\Models\Status::where('type', 'organization_status')
                ->where('name', 'active')
                ->first();
            
            \App\Models\OrganizationMember::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'organization_id' => $request->organization_id,
                    'status_id' => $activeStatus->id ?? 1,
                    'membership_start_date' => now(),
                    'updated_by' => auth()->id(),
                ]
            );
        } else {
            // Remove from organization if not a member
            \App\Models\OrganizationMember::where('user_id', $user->id)->delete();
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $currentUser = auth()->user();

        // Check if current user has permission to delete this user
        if (!$currentUser->hasRole('admin')) {
            if ($currentUser->hasRole('family leader')) {
                // Family leader can only delete their family members
                if ($user->family_leader != $currentUser->id && $user->id != $currentUser->id) {
                    abort(403, 'You can only delete your family members.');
                }
            } elseif ($currentUser->hasRole('group leader')) {
                // Group leader can only delete their group members
                if ($user->group_leader != $currentUser->id && $user->id != $currentUser->id) {
                    abort(403, 'You can only delete your group members.');
                }
            } else {
                // Other roles cannot delete any users
                abort(403, 'You do not have permission to delete users.');
            }
        }

        $user->delete();
        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully');
    }

    public function getRolePermissions(string $roleIds): JsonResponse
    {
        $roleIds = explode(',', $roleIds);
        $roles = Role::whereIn('id', $roleIds)->with('permissions')->get();
        $permissions = $roles->flatMap->permissions->pluck('id')->unique()->toArray();

        return response()->json($permissions);
    }

}
