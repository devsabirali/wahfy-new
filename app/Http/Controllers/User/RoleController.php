<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class RoleController extends Controller
{
    public function __construct()
    {
        // $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index', 'show']]);
        // $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
        // $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    public function index(): View
    {
        $roles = Role::with('permissions')->latest()->paginate(10);
        return view('admin.user-management.roles.index', compact('roles'));
    }

    public function create(): View
    {
        $permissions = Permission::get();
        return view('admin.user-management.roles.create', compact('permissions'));
    }

    public function store(Request $request): RedirectResponse
    {
        \Log::info('Role creation request data:', $request->all());
        
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        try {
            $role = Role::create(['name' => $request->input('name')]);
            
            // Convert permissions array to simple array of IDs
            $permissionIds = array_keys($request->input('permissions', []));
            $role->syncPermissions($permissionIds);

            return redirect()->route('admin.roles.index')
                ->with('success', 'Role created successfully');
        } catch (\Exception $e) {
            \Log::error('Role creation failed: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Failed to create role: ' . $e->getMessage());
        }
    }

    public function show($id): View
    {
        $role = Role::with('permissions')->findOrFail($id);
        return view('admin.user-management.roles.show', compact('role'));
    }

    public function edit($id): View
    {
        $role = Role::with('permissions')->findOrFail($id);
        $permissions = Permission::get();
        $rolePermissions = $role->permissions->pluck('id')->toArray();

        return view('admin.user-management.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name,' . $id,
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        $role = Role::findOrFail($id);
        $role->name = $request->input('name');
        $role->save();

        // Get the permission IDs from the request
        $permissionIds = array_keys($request->input('permissions', []));
        $role->syncPermissions($permissionIds);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Role::findOrFail($id)->delete();
        return redirect()->route('admin.roles.index')
            ->with('success', 'Role deleted successfully');
    }
}
