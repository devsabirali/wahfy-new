<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\Incident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminDonationController  extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if ($user && $user->hasRole('admin')) {
            $donations = Donation::with(['incident'])
                ->latest()
                ->paginate(10);
        } else {
            $incidentIds = \App\Models\Incident::where('user_id', $user->id)->pluck('id');
            $donations = Donation::with(['incident'])
                ->whereIn('incident_id', $incidentIds)
                ->latest()
                ->paginate(10);
        }
        return view('admin.donations.index', compact('donations'));
    }

    public function create()
    {
        $incidents = Incident::get();
        return view('admin.donations.create', compact('incidents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'amount' => 'required|numeric|min:0',
            'donation_type' => 'required|in:incident,general',
            'incident_id' => 'required_if:donation_type,incident|exists:incidents,id',
            'payment_method' => 'required|in:card,offline',
            'status' => 'required|in:pending,approved,rejected',
            'notes' => 'nullable|string'
        ]);

        try {
            $donation = Donation::create($validated);
            Log::info('Donation created successfully', ['donation_id' => $donation->id]);
            return redirect()->route('admin.donations.index')->with('success', 'Donation created successfully');
        } catch (\Exception $e) {
            Log::error('Error creating donation', ['error' => $e->getMessage()]);
            return back()->with('error', 'Error creating donation. Please try again.');
        }
    }

    public function show(Donation $donation)
    {
        $donation->load(['incident']);
        return view('admin.donations.show', compact('donation'));
    }

    public function edit(Donation $donation)
    {
        $incidents = Incident::get();
        return view('admin.donations.edit', compact('donation', 'incidents'));
    }

    public function update(Request $request, Donation $donation)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'amount' => 'required|numeric|min:0',
            'donation_type' => 'required|in:incident,general',
            'incident_id' => 'required_if:donation_type,incident|exists:incidents,id',
            'payment_method' => 'required|in:card,offline',
            'status' => 'required|in:pending,approved,rejected',
            'notes' => 'nullable|string'
        ]);

        try {
            $donation->update($validated);
            Log::info('Donation updated successfully', ['donation_id' => $donation->id]);
            return redirect()->route('admin.donations.index')->with('success', 'Donation updated successfully');
        } catch (\Exception $e) {
            Log::error('Error updating donation', ['error' => $e->getMessage()]);
            return back()->with('error', 'Error updating donation. Please try again.');
        }
    }

    public function destroy(Donation $donation)
    {
        try {
            $donation->delete();
            Log::info('Donation deleted successfully', ['donation_id' => $donation->id]);
            return redirect()->route('admin.donations.index')->with('success', 'Donation deleted successfully');
        } catch (\Exception $e) {
            Log::error('Error deleting donation', ['error' => $e->getMessage()]);
            return back()->with('error', 'Error deleting donation. Please try again.');
        }
    }

    public function pending()
    {
        $user = auth()->user();
        if ($user && $user->hasRole('admin')) {
            $pendingDonations = Donation::with(['incident'])
                ->where('payment_status', 'pending')
                ->latest()
                ->paginate(10);
        } else {
            $incidentIds = \App\Models\Incident::where('user_id', $user->id)->pluck('id');
            $pendingDonations = Donation::with(['incident'])
                ->where('payment_status', 'pending')
                ->whereIn('incident_id', $incidentIds)
                ->latest()
                ->paginate(10);
        }
        return view('admin.donations.pending', compact('pendingDonations'));
    }

    public function approve(Donation $donation)
    {
        try {
            $donation->update(['status' => 'approved']);
            Log::info('Donation approved successfully', ['donation_id' => $donation->id]);
            return redirect()->back()->with('success', 'Donation approved successfully');
        } catch (\Exception $e) {
            Log::error('Error approving donation', ['error' => $e->getMessage()]);
            return back()->with('error', 'Error approving donation. Please try again.');
        }
    }

    public function reject(Donation $donation)
    {
        try {
            $donation->update(['status' => 'rejected']);
            Log::info('Donation rejected successfully', ['donation_id' => $donation->id]);
            return redirect()->back()->with('success', 'Donation rejected successfully');
        } catch (\Exception $e) {
            Log::error('Error rejecting donation', ['error' => $e->getMessage()]);
            return back()->with('error', 'Error rejecting donation. Please try again.');
        }
    }
}
