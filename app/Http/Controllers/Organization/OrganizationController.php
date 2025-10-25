<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrganizationController extends Controller
{
    public function index()
    {
        $organizations = Organization::with(['leader', 'status'])
            ->latest()
            ->paginate(10);
        return view('admin.organizations.index', compact('organizations'));
    }

    public function create()
    {
        // Get users who are not already leaders of any organization and not members of any organization
        $leaders = User::role(['indivisual-member', 'family-leader', 'group-leader'])
            ->whereDoesntHave('organizations') // Not a leader of any organization
            ->whereDoesntHave('organizationMembers') // Not a member of any organization
            ->get();
        
        $statuses = Status::where('type', 'organization_status')
            ->whereIn('name', ['Active', 'Inactive'])
            ->get();
        return view('admin.organizations.create', compact('leaders', 'statuses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:family,group',
            'leader_id' => 'required|exists:users,id',
            'status_id' => 'required|exists:statuses,id'
        ]);

        // Check if the selected leader already has an organization
        $leader = User::find($request->leader_id);
        if ($leader->organizations()->exists() || $leader->organizationMembers()->exists()) {
            return back()->with('error', 'The selected leader is already associated with an organization.')
                        ->withInput();
        }

        DB::beginTransaction();
        try {
            $organization = Organization::create([
                'name' => $request->name,
                'type' => $request->type,
                'leader_id' => $request->leader_id,
                'status_id' => $request->status_id,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id()
            ]);

            // Create leader history
            $organization->leaderHistory()->create([
                'user_id' => $request->leader_id,
                'start_date' => now(),
                'reason' => 'initial',
                'created_by' => Auth::id(),
                'updated_by' => Auth::id()
            ]);

            DB::commit();
            return redirect()->route('admin.organizations.index')
                ->with('success', 'Organization created successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error creating organization: ' . $e->getMessage());
        }
    }

    public function show(Organization $organization)
    {
        $organization->load(['leader', 'status', 'members.user', 'leaderHistory.user']);
        return view('admin.organizations.show', compact('organization'));
    }

    public function edit(Organization $organization)
    {
        // Get users who are not already leaders of any organization and not members of any organization
        // Include current leader in the list
        $leaders = User::role(['indivisual-member', 'family-leader', 'group-leader'])
            ->where(function($query) use ($organization) {
                $query->whereDoesntHave('organizations') // Not a leader of any organization
                      ->whereDoesntHave('organizationMembers') // Not a member of any organization
                      ->orWhere('id', $organization->leader_id); // Or is the current leader
            })
            ->get();
        
        $statuses = Status::where('type', 'organization_status')
            ->whereIn('name', ['Active', 'Inactive'])
            ->get();
        return view('admin.organizations.edit', compact('organization', 'leaders', 'statuses'));
    }

    public function update(Request $request, Organization $organization)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:family,group',
            'leader_id' => 'required|exists:users,id',
            'status_id' => 'required|exists:statuses,id'
        ]);

        // Check if the selected leader already has an organization (only if leader is being changed)
        if ($request->leader_id != $organization->leader_id) {
            $leader = User::find($request->leader_id);
            if ($leader->organizations()->exists() || $leader->organizationMembers()->exists()) {
                return back()->with('error', 'The selected leader is already associated with an organization.')
                            ->withInput();
            }
        }

        DB::beginTransaction();
        try {
            $organization->update([
                'name' => $request->name,
                'type' => $request->type,
                'leader_id' => $request->leader_id,
                'status_id' => $request->status_id,
                'updated_by' => Auth::id()
            ]);

            // If leader changed, create new history entry
            if ($organization->wasChanged('leader_id')) {
                // End current leader's term
                $organization->leaderHistory()
                    ->whereNull('end_date')
                    ->update([
                        'end_date' => now(),
                        'reason' => 'resignation',
                        'updated_by' => Auth::id()
                    ]);

                // Start new leader's term
                $organization->leaderHistory()->create([
                    'user_id' => $request->leader_id,
                    'start_date' => now(),
                    'reason' => 'succession',
                    'created_by' => Auth::id(),
                    'updated_by' => Auth::id()
                ]);
            }

            DB::commit();
            return redirect()->route('admin.organizations.index')
                ->with('success', 'Organization updated successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error updating organization: ' . $e->getMessage());
        }
    }

    public function destroy(Organization $organization)
    {
        try {
            $organization->delete();
            return redirect()->route('admin.organizations.index')
                ->with('success', 'Organization deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting organization: ' . $e->getMessage());
        }
    }

    public function change()
    {
        $user = Auth::user();
        $organizations = collect();
        
        // Role-based organization access
        if ($user->hasRole('admin')) {
            // Admin can see all organizations
            $organizations = Organization::with(['leader', 'status', 'members.user'])
                ->latest()
                ->get();
        } elseif ($user->hasRole(['family-leader', 'group-leader'])) {
            // Leaders can only see their own organization
            $userOrganization = $user->organizations;
            if ($userOrganization) {
                $organizations = collect([$userOrganization->load(['leader', 'status', 'members.user'])]);
            }
        } else {
            // Other users cannot access this page
            abort(403, 'Unauthorized access');
        }
        
        return view('admin.organizations.change', compact('organizations'));
    }

    public function change_post(Request $request)
    {
        // dd($request);
        $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'new_leader_id' => 'required|exists:users,id'
        ]);

        $user = Auth::user();
        $organization = Organization::findOrFail($request->organization_id);
        $newLeader = User::findOrFail($request->new_leader_id);
        $oldLeader = $organization->leader;

        // Check if user has permission to change this organization
        if (!$user->hasRole('admin') && $organization->leader_id !== $user->id) {
            return back()->with('error', 'You can only change leaders for your own organization.');
        }

        // Check if new leader is already a leader of another organization
        if ($newLeader->organizations()->exists()) {
            return back()->with('error', 'The selected user is already a leader of another organization.');
        }

        DB::beginTransaction();
        try {
            // Update organization leader
            $organization->update([
                'leader_id' => $newLeader->id,
                'updated_by' => $user->id
            ]);

            // End old leader's term
            $organization->leaderHistory()
                ->whereNull('end_date')
                ->update([
                    'end_date' => now(),
                    'reason' => 'resignation',
                    'updated_by' => $user->id
                ]);

            // Start new leader's term
            $organization->leaderHistory()->create([
                'user_id' => $newLeader->id,
                'start_date' => now(),
                'reason' => 'succession',
                'created_by' => $user->id,
                'updated_by' => $user->id
            ]);

            // Update user roles and organization membership
            $this->updateUserRolesAndMembership($oldLeader, $newLeader, $organization);

            DB::commit();
            return back()->with('success', 'Organization leader changed successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error changing organization leader: ' . $e->getMessage());
        }
    }

    public function getOrganizationMembers(Request $request)
    {
        $request->validate([
            'organization_id' => 'required|exists:organizations,id'
        ]);

        $user = Auth::user();
        $organization = Organization::findOrFail($request->organization_id);

        // Check if user has permission to view this organization's members
        if (!$user->hasRole('admin') && $organization->leader_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized access'], 403);
        }

        $members = $organization->members()
            ->with('user')
            ->get()
            ->map(function ($member) {
                return [
                    'id' => $member->user->id,
                    'name' => $member->user->name,
                    'email' => $member->user->email,
                    'phone' => $member->user->phone,
                    'membership_start_date' => $member->membership_start_date
                ];
            });

        return response()->json(['members' => $members]);
    }

    private function updateUserRolesAndMembership($oldLeader, $newLeader, $organization)
    {
        // Remove old leader's leadership role
        if ($oldLeader->hasRole('family-leader')) {
            $oldLeader->removeRole('family-leader');
        } elseif ($oldLeader->hasRole('group-leader')) {
            $oldLeader->removeRole('group-leader');
        }

        // Add old leader as organization member if not already a member
        if (!$oldLeader->organizationMembers()->where('organization_id', $organization->id)->exists()) {
            $organization->members()->create([
                'user_id' => $oldLeader->id,
                'status_id' => Status::where('type', 'member_status')->where('name', 'Active')->first()->id,
                'membership_start_date' => now(),
                'created_by' => Auth::id(),
                'updated_by' => Auth::id()
            ]);
        }

        // Assign appropriate role to old leader
        $oldLeader->assignRole('member');

        // Remove new leader from any organization membership
        $newLeader->organizationMembers()->where('organization_id', $organization->id)->delete();

        // Transfer payment status from old leader to new leader
        $newLeader->update(['payment_status' => $oldLeader->payment_status]);
        
        // Assign appropriate leadership role to new leader
        if ($organization->type === 'family') {
            $newLeader->assignRole('family-leader');
            $newLeader->update(['family_leader' => 1, 'family_name' => $organization->name]);
        } elseif ($organization->type === 'group') {
            $newLeader->assignRole('group-leader');
            $newLeader->update(['group_leader' => 1, 'group_name' => $organization->name]);
        }

        // Update old leader's flags
        if ($organization->type === 'family') {
            $oldLeader->update(['family_leader' => 0, 'family_name' => null]);
        } elseif ($organization->type === 'group') {
            $oldLeader->update(['group_leader' => 0, 'group_name' => null]);
        }
    }
}
