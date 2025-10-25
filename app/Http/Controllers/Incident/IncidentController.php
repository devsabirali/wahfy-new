<?php

namespace App\Http\Controllers\Incident;

use App\Http\Controllers\Controller;
use App\Models\Contribution;
use App\Models\Incident;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class IncidentController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Use the user's method to get accessible incidents
        $incidents = $user->getAccessibleIncidents()
            ->latest()
            ->paginate(10);

        // Get probation status for the current user
        $probationStatus = $user->getProbationStatus();
        $isAdmin = $user->hasRole('admin');

        return view('admin.incidents.index', compact('incidents', 'probationStatus', 'isAdmin'));
    }

    public function create()
    {
        $user = Auth::user();

        // Check if user is admin or probation is completed
        if (!$user->hasRole('admin') && !$user->isProbationCompleted()) {
            return redirect()->route('admin.incidents.index')
                ->with('error', 'You cannot create incidents until your 6-month probation period is completed.');
        }

        // Restrict users list for non-admin users
        if ($user->hasRole('admin')) {
            $users = User::all();
        } else {
            // For non-admin users, only show themselves and their organization members
            $organization = $user->getOrganization();
            if ($organization) {
                $organizationUserIds = $organization->members()->pluck('user_id')->toArray();
                $organizationUserIds[] = $user->id; // Include current user
                $users = User::whereIn('id', $organizationUserIds)->get();
            } else {
                // If no organization, only show themselves
                $users = User::where('id', $user->id)->get();
            }
        }

        $types = ['healthcare', 'death'];
        $statuses = Status::where('type', 'incident_status')->get();
        $probationStatus = $user->getProbationStatus();
        $isAdmin = $user->hasRole('admin');
        return view('admin.incidents.create', compact('users', 'statuses', 'types', 'probationStatus', 'isAdmin'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        // Check if user is admin or probation is completed
        if (!$user->hasRole('admin') && !$user->isProbationCompleted()) {
            return redirect()->route('admin.incidents.index')
                ->with('error', 'You cannot create incidents until your 6-month probation period is completed.');
        }

        $isAdmin = $user->hasRole('admin');

        // Validation rules - status_id is required only for admin users
        $validationRules = [
            'user_id' => 'required|exists:users,id',
            'deceased_name' => 'required|string|max:255',
            'date_of_death' => 'required|date',
            'description' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:healthcare,death',
            'thumbnail_path' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ];

        if ($isAdmin) {
            $validationRules['status_id'] = 'required|exists:statuses,id';
        }

        $request->validate($validationRules);

        // Additional validation for non-admin users - they can only create incidents for themselves or organization members
        if (!$isAdmin) {
            $organization = $user->getOrganization();
            $allowedUserIds = [$user->id]; // Include current user

            if ($organization) {
                $organizationUserIds = $organization->members()->pluck('user_id')->toArray();
                $allowedUserIds = array_merge($allowedUserIds, $organizationUserIds);
            }

            if (!in_array($request->user_id, $allowedUserIds)) {
                return back()->with('error', 'You can only create incidents for yourself or members of your organization.');
            }
        }

        // For non-admin users, set status to pending
        $statusId = $isAdmin ? $request->status_id : Status::where('name', 'pending')->value('id');

        $incident = Incident::create([
            'user_id' => $request->user_id,
            'deceased_name' => $request->deceased_name,
            'date_of_death' => $request->date_of_death,
            'description' => $request->description,
            'amount' => $request->amount,
            'status_id' => $statusId,
            'type' => $request->type,
            'verified_by' => $isAdmin ? $request->verified_by : null,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
            'thumbnail_path' => null
        ]);

            // Log activity
            \App\Helpers\ActivityLogger::log(
                'incident_created',
                'Incident created for user ID ' . $request->user_id . ', type: ' . $request->type . ', amount: ' . $request->amount
            );

        if ($request->hasFile('thumbnail_path')) {
            $thumbnail = $request->file('thumbnail_path');
            $thumbnailPath = $thumbnail->store('incidents/thumbnails/' . $incident->id, 'public');
            $incident->update(['thumbnail_path' => $thumbnailPath]);
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('incidents/' . $incident->id, 'public');
                $incident->images()->create([
                    'image_path' => $path,
                    'image_type' => 'other',
                    'created_by' => Auth::id(),
                    'updated_by' => Auth::id()
                ]);
            }
        }

        return redirect()->route('admin.incidents.index')
            ->with('success', 'Incident created successfully.');
    }

    public function show(Incident $incident)
    {
        $user = Auth::user();

        // Check if user has access to this incident (non-admin users can only view their own or organization incidents)
        if (!$user->hasRole('admin')) {
            $accessibleIncidents = $user->getAccessibleIncidents();
            if (!$accessibleIncidents->where('id', $incident->id)->exists()) {
                return redirect()->route('admin.incidents.index')
                    ->with('error', 'You do not have permission to view this incident.');
            }
        }

        $incident->load(['user', 'status', 'verifiedBy', 'images']);
        $probationStatus = $user->getProbationStatus();
        $isAdmin = $user->hasRole('admin');
        return view('admin.incidents.show', compact('incident', 'probationStatus', 'isAdmin'));
    }

    public function edit(Incident $incident)
    {
        $user = Auth::user();

        // Check if user has access to this incident (non-admin users can only edit their own or organization incidents)
        if (!$user->hasRole('admin')) {
            $accessibleIncidents = $user->getAccessibleIncidents();
            if (!$accessibleIncidents->where('id', $incident->id)->exists()) {
                return redirect()->route('admin.incidents.index')
                    ->with('error', 'You do not have permission to edit this incident.');
            }
        }

        // Restrict users list for non-admin users
        if ($user->hasRole('admin')) {
            $users = User::all();
        } else {
            // For non-admin users, only show themselves and their organization members
            $organization = $user->getOrganization();
            if ($organization) {
                $organizationUserIds = $organization->members()->pluck('user_id')->toArray();
                $organizationUserIds[] = $user->id; // Include current user
                $users = User::whereIn('id', $organizationUserIds)->get();
            } else {
                // If no organization, only show themselves
                $users = User::where('id', $user->id)->get();
            }
        }

        $types = ['healthcare', 'death'];
        $statuses = Status::where('type', 'incident_status')->get();
        $probationStatus = $user->getProbationStatus();
        $isAdmin = $user->hasRole('admin');
        return view('admin.incidents.edit', compact('incident', 'users', 'statuses', 'types', 'probationStatus', 'isAdmin'));
    }

    public function update(Request $request, Incident $incident)
    {
        $user = Auth::user();
        $isAdmin = $user->hasRole('admin');

        // Validation rules - status_id is required only for admin users
        $validationRules = [
            'user_id' => 'required|exists:users,id',
            'deceased_name' => 'required|string|max:255',
            'date_of_death' => 'required|date',
            'description' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:healthcare,death',
            'thumbnail_path' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ];

        if ($isAdmin) {
            $validationRules['status_id'] = 'required|exists:statuses,id';
        }

        $request->validate($validationRules);

        // Additional validation for non-admin users - they can only update incidents for themselves or organization members
        if (!$isAdmin) {
            $organization = $user->getOrganization();
            $allowedUserIds = [$user->id]; // Include current user

            if ($organization) {
                $organizationUserIds = $organization->members()->pluck('user_id')->toArray();
                $allowedUserIds = array_merge($allowedUserIds, $organizationUserIds);
            }

            if (!in_array($request->user_id, $allowedUserIds)) {
                return back()->with('error', 'You can only update incidents for yourself or members of your organization.');
            }
        }

        DB::beginTransaction();
        try {
            // For non-admin users, don't update status and verified_by
            $updateData = [
                'user_id' => $request->user_id,
                'deceased_name' => $request->deceased_name,
                'date_of_death' => $request->date_of_death,
                'description' => $request->description,
                'amount' => $request->amount,
                'type' => $request->type,
                'updated_by' => Auth::id()
            ];

            if ($isAdmin) {
                $updateData['status_id'] = $request->status_id;
                $updateData['verified_by'] = $request->verified_by;
            }

            $incident->update($updateData);

            if ($request->hasFile('thumbnail_path')) {
                if ($incident->thumbnail_path) {
                    Storage::disk('public')->delete($incident->thumbnail_path);
                }
                $thumbnail = $request->file('thumbnail_path');
                $thumbnailPath = $thumbnail->store('incidents/thumbnails/' . $incident->id, 'public');
                $incident->update(['thumbnail_path' => $thumbnailPath]);
            }

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('incidents/' . $incident->id, 'public');
                    $incident->images()->create([
                        'image_path' => $path,
                        'image_type' => 'other',
                        'created_by' => Auth::id(),
                        'updated_by' => Auth::id()
                    ]);
                }
            }

            $this->createContributionsForMembers($incident);

            DB::commit();
            return redirect()->route('admin.incidents.index')
                ->with('success', 'Incident updated successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error updating incident: ' . $e->getMessage());
        }
    }

    private function createContributionsForMembers(Incident $incident)
    {
        $verifiedStatusId = Status::where('name', 'Verified')->value('id');
        $inProgressStatusId = Status::where('name', 'Inprogress')->value('id');
        $pendingPaymentStatusId = Status::where('type', 'payment_status')
            ->where('name', 'pending') // should be pending
            ->value('id');

        // Check if incident is verified or in progress and no contributions exist yet
        if (
            ((int)$incident->status_id === (int)$verifiedStatusId || (int)$incident->status_id === (int)$inProgressStatusId) &&
            Contribution::where('incident_id', $incident->id)->count() === 0
        ) {
            $users = User::role('member')->get();
            $userCount = $users->count();

            if ($userCount > 0) {
                $share = $incident->amount / $userCount;

                $contributions = $users->map(fn($user) => [
                    'incident_id' => $incident->id,
                    'user_id' => $user->id,
                    'amount' => $share,
                    'admin_fee' => 0,
                    'transaction_id' => null, // Will be set when payment is made
                    'status_id' => $pendingPaymentStatusId,
                    'created_by' => Auth::id(),
                    'updated_by' => Auth::id(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ])->toArray();

                try {
                    Contribution::insert($contributions);
                } catch (\Exception $e) {
                    throw new \Exception('Contribution insertion failed: ' . $e->getMessage());
                }
            }
        }
    }



    public function destroy(Incident $incident)
    {
        $user = Auth::user();

        // Check if user has access to this incident (non-admin users can only delete their own or organization incidents)
        if (!$user->hasRole('admin')) {
            $accessibleIncidents = $user->getAccessibleIncidents();
            if (!$accessibleIncidents->where('id', $incident->id)->exists()) {
                return redirect()->route('admin.incidents.index')
                    ->with('error', 'You do not have permission to delete this incident.');
            }
        }

        try {
            // Delete associated images from storage
            foreach ($incident->images as $image) {
                Storage::disk('public')->delete($image->image_path);
            }

            $incident->delete();
            return redirect()->route('admin.incidents.index')
                ->with('success', 'Incident deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting incident: ' . $e->getMessage());
        }
    }

    public function verify(Incident $incident)
    {
        try {
            DB::beginTransaction();

            $verifiedStatus = Status::where('name', 'Verified')->where('type','incident_status')->first();
            $incident->update([
                'status_id' => $verifiedStatus->id,
                'verified_by' => Auth::id(),
                'updated_by' => Auth::id()
            ]);

            // Create contributions for all members when incident is verified
            $this->createContributionsForMembers($incident);

            DB::commit();
            return redirect()->route('admin.incidents.show', $incident)
                ->with('success', 'Incident verified successfully and contributions created for all members.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error verifying incident: ' . $e->getMessage());
        }
    }

    public function deceased()
    {
        $user = Auth::user();

        // Use the user's method to get accessible incidents filtered by type
        $incidents = $user->getAccessibleIncidents()
            ->where('type', 'death')
            ->latest()
            ->paginate(10);

        // Get probation status for the current user
        $probationStatus = $user->getProbationStatus();
        $isAdmin = $user->hasRole('admin');

        return view('admin.incidents.index', compact('incidents', 'probationStatus', 'isAdmin'));
    }
    public function healthcare()
    {
        $user = Auth::user();

        // Use the user's method to get accessible incidents filtered by type
        $incidents = $user->getAccessibleIncidents()
            ->where('type', 'healthcare')
            ->latest()
            ->paginate(10);

        // Get probation status for the current user
        $probationStatus = $user->getProbationStatus();
        $isAdmin = $user->hasRole('admin');

        return view('admin.incidents.index', compact('incidents', 'probationStatus', 'isAdmin'));
    }
}
