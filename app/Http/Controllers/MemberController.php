<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $memberRoles = [
            'member',
            'indivisual-member',
            'family-member',
            'group-member',
            'family-leader',
            'group-leader'
        ];
        
        $user = Auth::user();
        $isAdmin = $user->hasRole(['admin', 'super-admin']);
        
        if ($isAdmin) {
            // Admin can see all members
            $members = \App\Models\User::whereHas('roles', function($q) use ($memberRoles) {
                $q->whereIn('name', $memberRoles);
            })->get();
        } else {
            // Members and leaders can only see their own organization members
            $userOrganizationIds = [];
            
            // Get organizations where user is a leader
            $userOrganizations = \App\Models\Organization::where('leader_id', $user->id)->pluck('id');
            $userOrganizationIds = array_merge($userOrganizationIds, $userOrganizations->toArray());
            
            // Get organizations where user is a member
            $userMemberOrganizations = \App\Models\OrganizationMember::where('user_id', $user->id)->pluck('organization_id');
            $userOrganizationIds = array_merge($userOrganizationIds, $userMemberOrganizations->toArray());
            
            // Remove duplicates
            $userOrganizationIds = array_unique($userOrganizationIds);
            
            if (empty($userOrganizationIds)) {
                // If user is not part of any organization, show only themselves
                $members = \App\Models\User::where('id', $user->id)
                    ->whereHas('roles', function($q) use ($memberRoles) {
                        $q->whereIn('name', $memberRoles);
                    })->get();
            } else {
                // Show members from user's organizations
                $members = \App\Models\User::whereHas('roles', function($q) use ($memberRoles) {
                    $q->whereIn('name', $memberRoles);
                })->where(function($query) use ($userOrganizationIds, $user) {
                    $query->whereIn('id', function($subQuery) use ($userOrganizationIds) {
                        $subQuery->select('user_id')
                            ->from('organization_members')
                            ->whereIn('organization_id', $userOrganizationIds);
                    })->orWhere('id', $user->id); // Include the user themselves
                })->get();
            }
        }
        
        return view('admin.members.index', compact('members'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
