<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\OrganizationMember;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrganizationMemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Organization $organization)
    {
        $members = $organization->members()
            ->with(['user', 'status'])
            ->latest()
            ->paginate(10);
        return view('admin.organizations.members.index', compact('organization', 'members'));
    }

    public function create(Organization $organization)
    {
        // Get users who are not already members of this organization
        $users = User::whereDoesntHave('organizationMembers', function ($query) use ($organization) {
            $query->where('organization_id', $organization->id);
        })->get();

        $statuses = Status::where('type', 'general')->get();

        return view('admin.organizations.members.create', compact('organization', 'users', 'statuses'));
    }

    public function store(Request $request, Organization $organization)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'status_id' => 'required|exists:statuses,id',
            'membership_start_date' => 'required|date'
        ]);

        try {
            DB::beginTransaction();

            $member = new OrganizationMember([
                'user_id' => $request->user_id,
                'status_id' => $request->status_id,
                'membership_start_date' => $request->membership_start_date,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id()
            ]);

            $organization->members()->save($member);

            DB::commit();

            return redirect()
                ->route('admin.organizations.members.index', $organization)
                ->with('success', 'Member added successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Error adding member: ' . $e->getMessage());
        }
    }

    public function edit(Organization $organization, OrganizationMember $member)
    {
        $statuses = Status::where('type', 'general')->get();
        $users = User::whereDoesntHave('organizationMembers', function ($query) use ($organization, $member) {
            $query->where('organization_id', $organization->id)
                  ->where('user_id', '!=', $member->user_id);
        })->orWhere('id', $member->user_id)->get();
        return view('admin.organizations.members.edit', compact('organization', 'member', 'statuses','users'));
    }

    public function update(Request $request, Organization $organization, OrganizationMember $member)
    {
        $request->validate([
            'status_id' => 'required|exists:statuses,id',
            'membership_start_date' => 'required|date'
        ]);

        try {
            $member->update([
                'status_id' => $request->status_id,
                'membership_start_date' => $request->membership_start_date,
                'updated_by' => Auth::id()
            ]);

            return redirect()
                ->route('admin.organizations.members.index', $organization)
                ->with('success', 'Member updated successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error updating member: ' . $e->getMessage());
        }
    }

    public function destroy(Organization $organization, OrganizationMember $member)
    {
        try {
            $member->delete();
            return redirect()
                ->route('admin.organizations.members.index', $organization)
                ->with('success', 'Member removed successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error removing member: ' . $e->getMessage());
        }
    }
}
