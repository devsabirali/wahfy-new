<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Donation;
use App\Models\Incident;
use App\Models\Organization;
use App\Models\Contact;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->hasRole(['admin', 'super-admin', 'family-leader', 'group-leader', 'indivisual-member','member'])) {
                return redirect()->route('home');
            }
            return $next($request);
        });


    }



public function index()
{
    // --- 1. INITIAL SETUP AND ROLE DETERMINATION ---
    $user = Auth::user();

    // Define all roles for cleaner checks
    $leaderRoles = ['family-leader', 'group-leader', 'leader'];
    $memberRoles = ['member', 'indivisual-member', 'family-member', 'group-member'];

    $isAdmin = $user->hasRole('admin');
    $isLeader = $user->hasAnyRole($leaderRoles);

    // Individual scope: Not Admin and not a Leader
    $isIndividual = !$isAdmin && !$isLeader;

    // --- 2. DEFINE SCOPE VARIABLES AND INITIAL QUERIES ---
    $memberIds = [$user->id]; // Start with self
    $organizationId = null;

    if ($isLeader) {
        // Find the organization this leader is currently leading
        $organization = Organization::where('leader_id', $user->id)
                                    ->where('status_id', 1) // Assuming 1 is 'active'
                                    ->first();

        if ($organization) {
            $organizationId = $organization->id;
            // Get all member IDs for the organization
            $memberIds = OrganizationMember::where('organization_id', $organizationId)
                                            ->where('status_id', 1)
                                            ->pluck('user_id')
                                            ->toArray();
            $memberIds[] = $user->id; // Always include the leader
        } else {
             // If they have a leader role but no active organization, revert to individual scope
             $isLeader = false;
             $isIndividual = true;
        }
    }

    // Initializing base query builders
    $userQuery = User::query();
    $donationQuery = Donation::query();
    $incidentQuery = Incident::query();
    $organizationQuery = Organization::query();

    // --- 3. APPLY SCOPES TO QUERIES (OPTIMIZATION) ---
    if ($isLeader) {
        // Leader Scope: Filter by member IDs of the organization
        $userQuery->whereIn('id', $memberIds);
        $organizationQuery->where('id', $organizationId);

        // Find incidents created by members in this group
        $groupIncidentIds = Incident::whereIn('user_id', $memberIds)->pluck('id');

        // Scope Donations to those incidents (for contribution tracking)
        $donationQuery->whereIn('incident_id', $groupIncidentIds);

        // Scope Incidents to those created by members
        $incidentQuery->whereIn('user_id', $memberIds);

    } elseif ($isIndividual) {
        // Individual Scope: Filter by self (user ID)
        $userQuery->where('id', $user->id);
        // Donations to incidents created by the user
        $userIncidentIds = Incident::where('user_id', $user->id)->pluck('id');
        $donationQuery->whereIn('incident_id', $userIncidentIds);
        $incidentQuery->where('user_id', $user->id); // Incidents *created* by the user

        // Organizations will be 0, as only leaders own them
        $organizationQuery->where('leader_id', $user->id);
    }
    // If $isAdmin is true, no filters are applied, and queries remain global.

    // --- 4. CALCULATE CORE METRICS ---

    $totalUsers = $userQuery->count();
    $totalDonations = $donationQuery->count();
    $totalIncidents = $incidentQuery->count();
    $donationAmount = $donationQuery->sum('amount');

    // Calculate total donations received by incidents created by the user/group
    if ($isAdmin) {
        // Admin: sum all donations to incidents (incident_id not null)
        $totalReceivedDonations = Donation::whereNotNull('incident_id')->sum('amount');
    } elseif ($isLeader) {
        // Leader: sum donations to incidents created by group members
        $groupIncidentIds = Incident::whereIn('user_id', $memberIds)->pluck('id');
        $totalReceivedDonations = Donation::whereIn('incident_id', $groupIncidentIds)->sum('amount');
    } else {
        // Individual: sum donations to incidents created by the user
        $userIncidentIds = Incident::where('user_id', $user->id)->pluck('id');
        $totalReceivedDonations = Donation::whereIn('incident_id', $userIncidentIds)->sum('amount');
    }

    // Total Organizations (Conditional)
    if ($isAdmin) {
        $totalOrganizations = Organization::count();
    } elseif ($isLeader) {
        $totalOrganizations = $organizationQuery->count(); // 1 if active, 0 otherwise
    } else {
        $totalOrganizations = 0;
    }

    // Total Members (Conditional)
    if ($isLeader) {
        $totalMembers = $totalUsers; // Total Users in scope is the Member count
    } elseif ($isAdmin) {
        $allMemberRoles = array_merge($memberRoles, $leaderRoles);
        $totalMembers = User::whereHas('roles', function($q) use ($allMemberRoles) {
            $q->whereIn('name', $allMemberRoles);
        })->count();
    } else {
        // Individual member count: 1 if they hold a member role, 0 otherwise
        $totalMembers = $user->hasAnyRole($memberRoles) ? 1 : 0;
    }

    // --- 5. CHART DATA (Use cloned queries for aggregation) ---

    $yearFilter = now()->year;

    // Monthly Donations
    $donationsPerMonth = (clone $donationQuery)->select(
        DB::raw('MONTH(created_at) as month'),
        DB::raw('COUNT(*) as count')
    )->whereYear('created_at', $yearFilter)
    ->groupBy('month')->pluck('count', 'month')->toArray();

    // Monthly Incidents
    $incidentsPerMonth = (clone $incidentQuery)->select(
        DB::raw('MONTH(created_at) as month'),
        DB::raw('COUNT(*) as count')
    )->whereYear('created_at', $yearFilter)
    ->groupBy('month')->pluck('count', 'month')->toArray();

    // Yearly Donations
    $donationsPerYear = (clone $donationQuery)->select(
        DB::raw('YEAR(created_at) as year'),
        DB::raw('SUM(amount) as total')
    )->groupBy('year')->pluck('total', 'year')->toArray();

    // Yearly Incidents
    $incidentsPerYear = (clone $incidentQuery)->select(
        DB::raw('YEAR(created_at) as year'),
        DB::raw('COUNT(*) as count')
    )->groupBy('year')->pluck('count', 'year')->toArray();


    // --- 6. AGGREGATE CHART LABELS AND RECENT DATA ---

    $allMonths = array_unique(array_merge(array_keys($donationsPerMonth), array_keys($incidentsPerMonth)));
    sort($allMonths);
    $months = array_map(fn($m) => date('M', mktime(0,0,0,$m,1)), $allMonths);

    $years = array_unique(array_merge(array_keys($donationsPerYear), array_keys($incidentsPerYear)));
    sort($years);

    // Recent Donations (Scoped)
    $recentDonations = (clone $donationQuery)->latest()->take(5)->get();

    // Recent Contacts (Admin only)
    // Assuming Contact model is global and not tied to organizations
    $recentContacts = $isAdmin ? Contact::latest()->take(5)->get() : collect();

    // --- 7. RETURN VIEW ---
    $roleDisplay = 'Member'; // default
    if ($user->hasRole('super-admin')) {
        $roleDisplay = 'Super Admin';
    } elseif ($user->hasRole('admin')) {
        $roleDisplay = 'Admin';
    } elseif ($user->hasRole('family-leader')) {
        $roleDisplay = 'Family Leader';
    } elseif ($user->hasRole('group-leader')) {
        $roleDisplay = 'Group Leader';
    } elseif ($user->hasRole('leader')) {
        $roleDisplay = 'Leader';
    } elseif ($user->hasRole('family-member')) {
        $roleDisplay = 'Family Member';
    } elseif ($user->hasRole('group-member')) {
        $roleDisplay = 'Group Member';
    } elseif ($user->hasRole('indivisual-member')) {
        $roleDisplay = 'Individual Member';
    }
    return view('admin.dashboard', compact(
        'totalUsers',
        'totalDonations',
        'totalIncidents',
        'totalOrganizations',
        'totalMembers',
        'donationAmount',
        'donationsPerMonth',
        'incidentsPerMonth',
        'months',
        'recentContacts',
        'recentDonations',
        'donationsPerYear',
        'incidentsPerYear',
        'years',
        'totalReceivedDonations', // <-- add this to the view
        'isAdmin', // <-- add this to the view
        'roleDisplay'
    ));
}
}
