<?php

namespace App\Http\Controllers\Contribution;

use App\Http\Controllers\Controller;
use App\Models\Contribution;
use App\Models\Status;
use App\Models\Transaction;
use App\Models\PaymentMethod;
use App\Models\Payment;
use App\Models\PaymentHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ContributionController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Contribution::with(['user', 'incident', 'status', 'transaction']);

        // Role-based filtering
        if ($user->hasRole('admin')) {
            // Admin sees all contributions
            $statusFilter = $request->get('status', 'all');
            if ($statusFilter !== 'all') {
                $statusId = Status::where('type', 'payment_status')
                    ->where('name', $statusFilter)
                    ->value('id');
                if ($statusId) {
                    $query->where('status_id', $statusId);
                }
            }
        } elseif ($user->hasRole('leader')) {
            // Leader sees contributions from their organization members
            $organization = $user->getOrganization();
            if ($organization) {
                $memberIds = $organization->members()->pluck('user_id')->toArray();
                $memberIds[] = $user->id; // Include leader's own contributions
                $query->whereIn('user_id', $memberIds);
            } else {
                // If no organization, only show their own
                $query->where('user_id', $user->id);
            }
        } else {
            // Regular members see only their own contributions
            $query->where('user_id', $user->id);
        }

        $contributions = $query->orderBy('created_at', 'desc')->paginate(10);

        // Get status options for filtering
        $statusOptions = Status::where('type', 'payment_status')->get();

        return view('admin.contributions.index', compact('contributions', 'statusOptions'));
    }

    public function show(Contribution $contribution)
    {
        $user = Auth::user();

        // Check access permissions
        if (!$this->canAccessContribution($contribution, $user)) {
            return redirect()->route('admin.contributions.index')
                ->with('error', 'You do not have permission to view this contribution.');
        }

        $contribution->load(['user', 'incident', 'status', 'transaction']);
        return view('admin.contributions.show', compact('contribution'));
    }

    public function pay(Contribution $contribution)
    {
        $user = Auth::user();

         if (!$this->canAccessContribution($contribution, $user)) {
            return redirect()->route('admin.contributions.index')
                ->with('error', 'You do not have permission to pay this contribution.');
        }

        if ($contribution->isPaid()) {
            return redirect()->route('admin.contributions.show', $contribution)
                ->with('error', 'This contribution has already been paid.');
        }

        $paymentMethods = PaymentMethod::where('is_active', true)->get();
        return view('admin.contributions.pay', compact('contribution', 'paymentMethods'));
    }

    public function processPayment(Request $request, Contribution $contribution)
    {
        $user = Auth::user();

        Log::info('Payment processing started', [
            'contribution_id' => $contribution->id,
            'user_id' => $user->id,
            'request_data' => $request->all()
        ]);

        // Check access permissions
        if (!$this->canAccessContribution($contribution, $user)) {
            Log::warning('Payment access denied', [
                'contribution_id' => $contribution->id,
                'user_id' => $user->id
            ]);
            return redirect()->route('admin.contributions.index')
                ->with('error', 'You do not have permission to pay this contribution.');
        }

        // Check if already paid
        if ($contribution->isPaid()) {
            Log::warning('Payment attempt on already paid contribution', [
                'contribution_id' => $contribution->id,
                'current_status_id' => $contribution->status_id
            ]);
            return redirect()->route('admin.contributions.show', $contribution)
                ->with('error', 'This contribution has already been paid.');
        }

        Log::info('Validating payment request', [
            'contribution_id' => $contribution->id,
            'payment_method' => $request->get('payment_method'),
            'stripe_payment_intent_id' => $request->get('stripe_payment_intent_id'),
            'payment_method_id' => $request->get('payment_method_id'),
            'all_request_data' => $request->all()
        ]);

        try {
            $validated = $request->validate([
                'payment_method' => 'required|in:stripe,offline',
                'payment_method_id' => 'required_if:payment_method,offline|nullable|exists:payment_methods,id',
                'stripe_payment_intent_id' => 'nullable|string',
            ]);

            Log::info('Payment request validated successfully', [
                'contribution_id' => $contribution->id,
                'validated_data' => $validated
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Payment validation failed', [
                'contribution_id' => $contribution->id,
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);
            throw $e;
        } catch (\Exception $e) {
            Log::error('Payment validation error', [
                'contribution_id' => $contribution->id,
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);
            throw $e;
        }

        // For Stripe payments, if no payment intent ID is provided, create one
        if ($validated['payment_method'] === 'stripe' && empty($validated['stripe_payment_intent_id'])) {
            Log::info('Creating Stripe payment intent for direct payment', [
                'contribution_id' => $contribution->id,
                'user_id' => $user->id,
                'amount' => $contribution->amount
            ]);

            try {
                \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

                $paymentIntent = \Stripe\PaymentIntent::create([
                    'amount' => (int)($contribution->amount * 100), // Convert to cents
                    'currency' => 'usd',
                    'metadata' => [
                        'contribution_id' => $contribution->id,
                        'user_id' => $user->id,
                        'incident_id' => $contribution->incident_id,
                    ],
                ]);

                $validated['stripe_payment_intent_id'] = $paymentIntent->id;

                Log::info('Stripe PaymentIntent created for direct payment', [
                    'contribution_id' => $contribution->id,
                    'payment_intent_id' => $paymentIntent->id,
                    'status' => $paymentIntent->status
                ]);

            } catch (\Exception $e) {
                Log::error('Failed to create Stripe payment intent', [
                    'error' => $e->getMessage(),
                    'contribution_id' => $contribution->id
                ]);

                return back()->with('error', 'Failed to initialize payment: ' . $e->getMessage());
            }
        }

        DB::beginTransaction();
        Log::info('Database transaction started', ['contribution_id' => $contribution->id]);

        try {
            // Create transaction record
            Log::info('Creating transaction record', [
                'contribution_id' => $contribution->id,
                'user_id' => $contribution->user_id,
                'amount' => $contribution->amount,
                'payment_method' => $validated['payment_method']
            ]);

            // Get transaction status - use existing payment_status entries
            $statusName = $validated['payment_method'] === 'stripe' ? 'paid' : 'pending';
            $transactionStatus = Status::where('type', 'payment_status')
                ->where('name', $statusName)
                ->first();

            if (!$transactionStatus) {
                // If status doesn't exist, create it
                $transactionStatus = Status::create([
                    'type' => 'payment_status',
                    'name' => $statusName,
                    'created_by' => $user->id,
                    'updated_by' => $user->id
                ]);
            }
            $transactionStatusId = $transactionStatus->id;

            Log::info('Transaction status retrieved/created', [
                'contribution_id' => $contribution->id,
                'status_name' => $statusName,
                'status_id' => $transactionStatusId
            ]);

            // Get or create payment method
            $paymentMethodId = $validated['payment_method_id'];
            if ($validated['payment_method'] === 'stripe' && !$paymentMethodId) {
                // Create or find a default Stripe payment method
                $stripePaymentMethod = PaymentMethod::firstOrCreate(
                    ['name' => 'stripe'],
                    ['is_active' => true, 'created_by' => $user->id, 'updated_by' => $user->id]
                );
                $paymentMethodId = $stripePaymentMethod->id;
            } elseif ($validated['payment_method'] === 'offline' && !$paymentMethodId) {
                // This shouldn't happen due to validation, but handle it gracefully
                Log::error('Offline payment without payment_method_id', [
                    'contribution_id' => $contribution->id,
                    'validated_data' => $validated
                ]);
                throw new \Exception('Payment method ID is required for offline payments');
            }

            $transaction = Transaction::create([
                'transaction_id' => 'TXN-' . time() . '-' . $contribution->id, // Generate unique transaction ID
                'payment_method_id' => $paymentMethodId,
                'amount' => $contribution->amount,
                'status_id' => $transactionStatusId,
                'payment_date' => now(),
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);

            Log::info('Transaction created successfully', [
                'contribution_id' => $contribution->id,
                'transaction_id' => $transaction->id
            ]);

            // Create payment record (without charge_id since contributions don't use charges)
            // Use the same status as transaction
            $paymentStatusId = $transactionStatusId;

            Log::info('Retrieved payment status ID', [
                'contribution_id' => $contribution->id,
                'payment_status_id' => $paymentStatusId,
                'status_name' => $validated['payment_method'] === 'stripe' ? 'completed' : 'pending'
            ]);

            Log::info('Creating payment record', [
                'contribution_id' => $contribution->id,
                'transaction_id' => $transaction->id,
                'payment_status_id' => $paymentStatusId,
                'amount' => $contribution->amount
            ]);

            $payment = Payment::create([
                'user_id' => $contribution->user_id,
                'transaction_id' => $transaction->id,
                'payment_method_id' => $paymentMethodId, // Use the same payment method ID as transaction
                'charge_id' => null, // Contributions don't use charges
                'amount' => $contribution->amount,
                'payment_type' => 'contribution',
                'status_id' => $paymentStatusId,
                'payment_date' => now()->toDateString(),
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);

            Log::info('Payment created successfully', [
                'contribution_id' => $contribution->id,
                'payment_id' => $payment->id,
                'transaction_id' => $transaction->id
            ]);

            // Update contribution status
            Log::info('Updating contribution status', [
                'contribution_id' => $contribution->id,
                'transaction_id' => $transaction->id,
                'status_id' => $paymentStatusId
            ]);

            $contribution->update([
                'transaction_id' => $transaction->id,
                'status_id' => $paymentStatusId,
                'updated_by' => $user->id,
            ]);

            Log::info('Contribution updated successfully', [
                'contribution_id' => $contribution->id,
                'new_status_id' => $contribution->status_id
            ]);

            // Create payment history for audit trail
            Log::info('Creating payment history record', [
                'contribution_id' => $contribution->id,
                'payment_id' => $payment->id
            ]);

            $paymentHistory = PaymentHistory::create([
                'user_id' => $contribution->user_id,
                'payment_id' => $payment->id,
                'amount' => $contribution->amount,
                'payment_method' => $validated['payment_method'] === 'stripe' ? 'Stripe' : 'Offline',
                'transaction_id' => $validated['stripe_payment_intent_id'] ?? $transaction->id,
                'status_id' => $paymentStatusId,
                'status' => $validated['payment_method'] === 'stripe' ? 'paid' : 'pending',
                'description' => "Contribution payment for incident: {$contribution->incident->deceased_name}",
                'metadata' => json_encode([
                    'contribution_id' => $contribution->id,
                    'incident_id' => $contribution->incident_id,
                    'payment_method_id' => $validated['payment_method_id'] ?? null,
                    'stripe_payment_intent_id' => $validated['stripe_payment_intent_id'] ?? null,
                ]),
                'paid_at' => $validated['payment_method'] === 'stripe' ? now() : null,
            ]);

            Log::info('Payment history created successfully', [
                'contribution_id' => $contribution->id,
                'payment_history_id' => $paymentHistory->id
            ]);

            DB::commit();
            Log::info('Database transaction committed successfully', [
                'contribution_id' => $contribution->id,
                'payment_id' => $payment->id,
                'transaction_id' => $transaction->id
            ]);

            $message = $validated['payment_method'] === 'stripe'
                ? 'Payment processed successfully!'
                : 'Payment recorded as offline. Admin will verify and complete the payment.';

            Log::info('Payment processing completed successfully', [
                'contribution_id' => $contribution->id,
                'payment_method' => $validated['payment_method'],
                'message' => $message
            ]);

            return redirect()->route('admin.contributions.show', $contribution)
                ->with('success', $message);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Payment processing error - transaction rolled back', [
                'error' => $e->getMessage(),
                'error_trace' => $e->getTraceAsString(),
                'contribution_id' => $contribution->id,
                'user_id' => $user->id,
                'validated_data' => $validated ?? null
            ]);

            return back()->with('error', 'Error processing payment: ' . $e->getMessage());
        }
    }

    public function markAsPaid(Request $request, Contribution $contribution)
    {
        $user = Auth::user();

        Log::info('Admin marking contribution as paid', [
            'contribution_id' => $contribution->id,
            'admin_user_id' => $user->id,
            'request_data' => $request->all()
        ]);

        // Only admin can mark as paid
        if (!$user->hasRole('admin')) {
            Log::warning('Non-admin user attempted to mark contribution as paid', [
                'contribution_id' => $contribution->id,
                'user_id' => $user->id
            ]);
            return redirect()->route('admin.contributions.index')
                ->with('error', 'You do not have permission to perform this action.');
        }

        $validated = $request->validate([
            'payment_method_id' => 'required|exists:payment_methods,id',
            'notes' => 'nullable|string|max:500',
        ]);

        Log::info('Admin mark as paid request validated', [
            'contribution_id' => $contribution->id,
            'validated_data' => $validated
        ]);

        DB::beginTransaction();
        try {
            // Create transaction record for offline payment
            $transaction = Transaction::create([
                'user_id' => $contribution->user_id,
                'amount' => $contribution->amount,
                'type' => 'contribution',
                'status' => 'completed',
                'payment_method_id' => $validated['payment_method_id'],
                'description' => "Offline payment for incident: {$contribution->incident->deceased_name}",
                'notes' => $validated['notes'],
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);

            // Create payment record (without charge_id since contributions don't use charges)
            $completedStatusId = Status::where('type', 'payment_status')
                ->where('name', 'paid')
                ->value('id');

            $payment = Payment::create([
                'user_id' => $contribution->user_id,
                'transaction_id' => $transaction->id,
                'charge_id' => null, // Contributions don't use charges
                'amount' => $contribution->amount,
                'payment_type' => 'contribution',
                'status_id' => $completedStatusId,
                'payment_date' => now()->toDateString(),
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);

            // Update contribution status to completed
            $contribution->update([
                'transaction_id' => $transaction->id,
                'status_id' => $completedStatusId,
                'updated_by' => Auth::id(),
            ]);

            // Create payment history for audit trail
            PaymentHistory::create([
                'user_id' => $contribution->user_id,
                'payment_id' => $payment->id,
                'amount' => $contribution->amount,
                'payment_method' => 'Admin Marked Paid',
                'transaction_id' => $transaction->id,
                'status_id' => $completedStatusId,
                'status' => 'paid',
                'description' => "Admin marked contribution as paid for incident: {$contribution->incident->deceased_name}",
                'metadata' => json_encode([
                    'contribution_id' => $contribution->id,
                    'incident_id' => $contribution->incident_id,
                    'payment_method_id' => $validated['payment_method_id'],
                    'notes' => $validated['notes'],
                    'marked_by_admin' => true,
                ]),
                'paid_at' => now(),
            ]);

            DB::commit();

            return redirect()->route('admin.contributions.show', $contribution)
                ->with('success', 'Contribution marked as paid successfully.');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error marking contribution as paid:', [
                'error' => $e->getMessage(),
                'contribution_id' => $contribution->id
            ]);

            return back()->with('error', 'Error marking contribution as paid: ' . $e->getMessage());
        }
    }

    public function createStripePaymentIntent(Request $request, Contribution $contribution)
    {
        $user = Auth::user();

        Log::info('Creating Stripe payment intent', [
            'contribution_id' => $contribution->id,
            'user_id' => $user->id,
            'amount' => $contribution->amount
        ]);

        // Check access permissions
        if (!$this->canAccessContribution($contribution, $user)) {
            Log::warning('Unauthorized Stripe payment intent creation attempt', [
                'contribution_id' => $contribution->id,
                'user_id' => $user->id
            ]);
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Check if already paid
        if ($contribution->isPaid()) {
            Log::warning('Stripe payment intent creation for already paid contribution', [
                'contribution_id' => $contribution->id,
                'current_status_id' => $contribution->status_id
            ]);
            return response()->json(['error' => 'Contribution already paid'], 400);
        }

        try {
            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

            Log::info('Creating Stripe PaymentIntent', [
                'contribution_id' => $contribution->id,
                'amount_cents' => (int)($contribution->amount * 100),
                'currency' => 'usd'
            ]);

            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => (int)($contribution->amount * 100), // Convert to cents
                'currency' => 'usd',
                'metadata' => [
                    'contribution_id' => $contribution->id,
                    'user_id' => $user->id,
                    'incident_id' => $contribution->incident_id,
                ],
            ]);

            Log::info('Stripe PaymentIntent created successfully', [
                'contribution_id' => $contribution->id,
                'payment_intent_id' => $paymentIntent->id,
                'status' => $paymentIntent->status
            ]);

            return response()->json([
                'client_secret' => $paymentIntent->client_secret,
                'payment_intent_id' => $paymentIntent->id,
            ]);

        } catch (\Exception $e) {
            Log::error('Stripe payment intent creation failed', [
                'error' => $e->getMessage(),
                'error_trace' => $e->getTraceAsString(),
                'contribution_id' => $contribution->id,
                'amount' => $contribution->amount
            ]);

            return response()->json(['error' => 'Failed to create payment intent'], 500);
        }
    }

    /**
     * Check if user can access a specific contribution
     */
    private function canAccessContribution(Contribution $contribution, $user)
    {
        // Admin can access all contributions
        if ($user->hasRole('admin')) {
            return true;
        }

        // Users can access their own contributions
        if ($contribution->user_id === $user->id) {
            return true;
        }

        // Leaders can access contributions from their organization members
        if ($user->hasRole('leader')) {
            $organization = $user->getOrganization();
            if ($organization) {
                $memberIds = $organization->members()->pluck('user_id')->toArray();
                return in_array($contribution->user_id, $memberIds);
            }
        }

        return false;
    }

}
