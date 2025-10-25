<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Incident;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DonationController extends Controller
{
    public function createPaymentIntent(Request $request)
    {
        try {
            Log::info('Donation request received:', $request->all());

            $request->validate([
                'amount' => 'required|numeric|min:1',
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'donation_type' => 'required|in:general,incident',
                'payment_method_id' => 'required|string'
            ]);

            Stripe::setApiKey(config('services.stripe.secret'));

            $amount = $request->input('amount') * 100; // Convert to cents for Stripe

            Log::info('Creating Stripe PaymentIntent with amount: ' . $amount);

            // Create PaymentIntent
            $paymentIntent = PaymentIntent::create([
                'amount' => $amount,
                'currency' => 'usd',
                'payment_method' => $request->payment_method_id,
                'confirm' => true,
                'automatic_payment_methods' => [
                    'enabled' => true,
                    'allow_redirects' => 'never'
                ],
                'metadata' => [
                    'incident_id' => $request->incident_id,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'donation_type' => $request->donation_type
                ]
            ]);

            Log::info('PaymentIntent created:', [
                'status' => $paymentIntent->status,
                'id' => $paymentIntent->id
            ]);

            if ($paymentIntent->status === 'succeeded') {
                return response()->json([
                    'success' => true,
                    'clientSecret' => $paymentIntent->client_secret,
                    'paymentIntentId' => $paymentIntent->id,
                    'message' => 'Payment intent created and confirmed successfully'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment intent created but not confirmed',
                    'status' => $paymentIntent->status
                ], 400);
            }

        } catch (\Exception $e) {
            Log::error('Donation error:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function completeDonation(Request $request)
    {
        try {
            DB::beginTransaction();

            $donation = Donation::create([
                'incident_id' => $request->incident_id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'amount' => $request->amount,
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_method === 'offline' ? 'pending' : 'completed',
                'payment_intent_id' => $request->payment_intent_id ?? null,
                'donation_type' => $request->donation_type
            ]);

            // Only update incident amount if payment is completed
            if ($request->payment_method !== 'offline' && $request->donation_type === 'incident' && $request->incident_id) {
                $incident = Incident::find($request->incident_id);
                if ($incident) {
                    $incident->amount += $request->amount;
                    $incident->save();
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => $request->payment_method === 'offline' ?
                    'Donation submitted for approval' :
                    'Donation completed successfully',
                'donation' => $donation
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error completing donation:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to complete donation: ' . $e->getMessage()
            ], 500);
        }
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'donation_type' => 'required|in:general,incident'
        ]);

        return view('site.checkout', [
            'amount' => $request->amount,
            'donation_type' => $request->donation_type,
            'incident_id' => $request->incident_id
        ]);
    }

    public function success()
    {
        return view('site.donation-success');
    }

    public function pending()
    {
        return view('site.donation-pending');
    }

    // Admin methods for managing pending donations
    public function pendingDonations()
    {
        $user = auth()->user();
        if ($user && $user->hasRole('admin')) {
            // Admin sees all pending donations
            $pendingDonations = Donation::where('payment_status', 'pending')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            // Non-admins see only donations for their own incidents
            $incidentIds = Incident::where('user_id', $user->id)->pluck('id');
            $pendingDonations = Donation::where('payment_status', 'pending')
                ->whereIn('incident_id', $incidentIds)
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }
        return view('admin.donations.pending', compact('pendingDonations'));
    }

    public function approveDonation($id)
    {
        try {
            DB::beginTransaction();

            $donation = Donation::findOrFail($id);
            $donation->payment_status = 'completed';
            $donation->save();

            // Update incident amount if it's an incident-based donation
            if ($donation->donation_type === 'incident' && $donation->incident_id) {
                $incident = Incident::find($donation->incident_id);
                if ($incident) {
                    $incident->amount += $donation->amount;
                    $incident->save();
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Donation approved successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error approving donation:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to approve donation: ' . $e->getMessage()
            ], 500);
        }
    }

    public function rejectDonation($id)
    {
        try {
            $donation = Donation::findOrFail($id);
            $donation->payment_status = 'rejected';
            $donation->save();

            return response()->json([
                'success' => true,
                'message' => 'Donation rejected successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error rejecting donation:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to reject donation: ' . $e->getMessage()
            ], 500);
        }
    }
}
