<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PermissionController extends Controller
{
    public function __construct()
    {
        // $this->middleware('permission:permission-list|permission-create|permission-edit|permission-delete', ['only' => ['index', 'show']]);
        // $this->middleware('permission:permission-create', ['only' => ['create', 'store']]);
        // $this->middleware('permission:permission-edit', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:permission-delete', ['only' => ['destroy']]);
    }

    public function index(): View
    {
        $permissions = Permission::latest()->paginate(500);
        return view('admin.user-management.permissions.index', compact('permissions'));
    }

    public function create(): View
    {
        return view('admin.user-management.permissions.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required|unique:permissions,name',
        ]);

        Permission::create(['name' => $request->input('name')]);

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission created successfully');
    }

    public function show($id): View
    {
        $permission = Permission::findOrFail($id);
        return view('admin.user-management.permissions.show', compact('permission'));
    }

    public function edit($id): View
    {
        $permission = Permission::findOrFail($id);
        return view('admin.user-management.permissions.edit', compact('permission'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required|unique:permissions,name,' . $id,
        ]);

        $permission = Permission::findOrFail($id);
        $permission->name = $request->input('name');
        $permission->save();

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Permission::findOrFail($id)->delete();
        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission deleted successfully');
    }
}
