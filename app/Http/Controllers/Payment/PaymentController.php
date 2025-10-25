<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Charge;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\Organimzation;
use App\Models\Organization;
use App\Models\Status;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['user', 'charge', 'transaction', 'status'])
            ->latest()
            ->paginate(10);
        return view('admin.payments.index', compact('payments'));
    }

    public function create()
    {
        $users = User::all();
        $charges = Charge::where('is_active', true)->get();
        $paymentMethods = PaymentMethod::all();
        $statuses = Status::where('type', 'payment_status')->get();
        return view('admin.payments.create', compact('users', 'charges', 'paymentMethods', 'statuses'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            // 'transaction_id' => 'required',
            'user_id' => 'required|exists:users,id',
            'charge_id' => 'required|exists:charges,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'amount' => 'required|numeric|min:0',
            'payment_type' => 'required|in:membership,contribution',
            'status_id' => 'required|exists:statuses,id',
            'payment_date' => 'required|date'
        ]);

        DB::beginTransaction();
        try {
        // Create transaction
        $transaction = Transaction::create([
            'transaction_id' => $request->transaction_id ?? 'Trx-' . now(),
            'payment_method_id' => $request->payment_method_id,
            'amount' => $request->amount,
            'status_id' => $request->status_id,
            'payment_date' => $request->payment_date,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id()
        ]);

        // Create payment
        $payment = Payment::create([
            'user_id' => $request->user_id,
            'charge_id' => $request->charge_id,
            'transaction_id' => $transaction->id,
            'amount' => $request->amount,
            'payment_type' => $request->payment_type,
            'status_id' => $request->status_id,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id()
        ]);

        // Create payment history
        // id	user_id	organization_id	payment_id	amount	payment_method	transaction_id	status	description	metadata	paid_at	created_at	updated_at	deleted_at
        // $status_name = Status::where('id', $request->status_id)->first()->pluck('name');
        // $payment_method = PaymentMethod::find($request->payment_method_id)?->name;
        // $payment->history()->create([
        //     'amount' => $payment->amount,
        //     'payment_method' => $payment_method,
        //     'status_id' => $request->status_id,
        //     'created_by' => Auth::id(),
        //     'updated_by' => Auth::id()
        // ]);


        // DB::commit();
            // Log activity
        ActivityLogger::log(
            'payment_created',
            'Payment created for user ID ' . $request->user_id . ', amount: ' . $request->amount
        );

        return redirect()->route('admin.payments.index')
            ->with('success', 'Payment created successfully.');
            } catch (\Exception $e) {
                DB::rollback();
                return back()->with('error', 'Error creating payment: ' . $e->getMessage());
            }
    }

    public function show(Payment $payment)
    {
        $payment->load(['user', 'charge', 'transaction', 'status', 'history.status']);
        return view('admin.payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        $users = User::all();
        $charges = Charge::where('is_active', true)->get();
        $paymentMethods = PaymentMethod::all();
        $statuses = Status::where('type', 'payment_status')->get();
        return view('admin.payments.edit', compact('payment', 'users', 'charges', 'paymentMethods', 'statuses'));
    }

    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'charge_id' => 'required|exists:charges,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'amount' => 'required|numeric|min:0',
            'payment_type' => 'required|in:membership,contribution',
            'status_id' => 'required|exists:statuses,id',
            'payment_date' => 'required|date'
        ]);

        DB::beginTransaction();
        try {
            // Update transaction
            $payment->transaction->update([
                'payment_method_id' => $request->payment_method_id,
                'amount' => $request->amount,
                'status_id' => $request->status_id,
                'payment_date' => $request->payment_date,
                'updated_by' => Auth::id()
            ]);

            // Update payment
            $payment->update([
                'user_id' => $request->user_id,
                'charge_id' => $request->charge_id,
                'amount' => $request->amount,
                'payment_type' => $request->payment_type,
                'status_id' => $request->status_id,
                'updated_by' => Auth::id()
            ]);

            // Create payment history if status changed
            if ($payment->wasChanged('status_id')) {
                $payment->history()->create([
                    'status_id' => $request->status_id,
                    'created_by' => Auth::id(),
                    'updated_by' => Auth::id()
                ]);
            }

            DB::commit();
            return redirect()->route('admin.payments.index')
                ->with('success', 'Payment updated successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error updating payment: ' . $e->getMessage());
        }
    }

    public function destroy(Payment $payment)
    {
        try {
            $payment->delete();
            return redirect()->route('admin.payments.index')
                ->with('success', 'Payment deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting payment: ' . $e->getMessage());
        }
    }
    public function registration()
    {
        $charge = Charge::where('is_active', true)->where('name', 'membership')->first();
        $method = PaymentMethod::where('is_active', true)->where('name', 'online')->first();

        $amount = $charge?->amount ?? 2.00;
        $chargeId = $charge?->id;
        $methodId = $method?->id;

        return view('admin.payments.registration', compact('amount', 'chargeId', 'methodId'));
    }

    // payment form after registration
    public function registration_store(Request $request)
    {

        $user = Auth::user();

        $request->validate([
            'charge_id' => 'required|exists:charges,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'amount' => 'required|numeric|min:0',
            'stripe_token' => 'required|string',
        ]);

        try {
            // Step 1: get pending and paid statuses
            $pendingStatus = Status::where('type', 'payment_status')->where('name', 'pending')->firstOrFail();
            $paidStatus = Status::where('type', 'payment_status')->where('name', 'paid')->firstOrFail();

            $transaction = Transaction::create([
                'transaction_id' => 'Trx-' . now()->timestamp,
                'payment_method_id' => $request->payment_method_id,
                'amount' => $request->amount,
                'status_id' => $pendingStatus->id,
                'payment_date' => now(),
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);

            // Step 3: create payment as pending
            $payment = Payment::create([
                'user_id' => $user->id,
                'charge_id' => $request->charge_id,
                'transaction_id' => $transaction->id,
                'amount' => $request->amount,
                'payment_type' => 'membership',
                'status_id' => $pendingStatus->id,
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);

            // Step 4: call Stripe API
            $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
            $charge = $stripe->paymentIntents->create([
                'amount' => $request->amount * 100,
                'currency' => 'usd',
                'payment_method' => $request->stripe_token,
                'confirm' => true,
                'automatic_payment_methods' => [
                    'enabled' => true,
                    'allow_redirects' => 'never'
                ],
            ]);

            if ($charge->status === 'succeeded') {

                $transaction->status_id = $paidStatus->id;
                $transaction->save();

                $payment->status_id = $paidStatus->id;
                $payment->save();

                $user->payment_status = 'paid';
                $user->save();

                return redirect()->route('payment.organization')
                    ->with('success', 'Payment successful. Welcome!');
            } else {
                throw new \Exception('Payment was not successful.');
            }
        } catch (\Exception $e) {
            \Log::error('Payment registration failed: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Payment failed: ' . $e->getMessage()]);
        }
    }

        public function organization()
    {
        $user = Auth::user();


        $leaderRoles = ['family-leader', 'group-leader', 'leader'];
        $individualRoles = ['indivisual-member', 'indivisual-leader'];

        $isLeader = $user->hasAnyRole($leaderRoles);
        $isAdmin = $user->hasRole('admin');

        $types = [];

        if ($isAdmin) {
            $types = ['individual', 'group', 'family'];
        }
        elseif ($user->group_leader || $user->hasRole('group-leader')) {
            $types = ['group'];
        }
        elseif ($user->family_leader || $user->hasRole('family-leader')) {
             $types = ['family'];
        }

        elseif ($user->hasAnyRole($individualRoles) || !$isLeader) {
              $types = ['individual'];
        }

        if (empty($types)) {
            $types = ['individual', 'group', 'family'];
        }

        return view('admin.payments.organization', compact('types'));
    }

    public function organization_store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:individual,family,group', // match your form options
        ]);

        DB::beginTransaction();

        try {
            // Get status: active, fallback to general, or create if missing
            $status = Status::where('type', 'organization_status')
                ->where('name', 'active')
                ->first();

            if (!$status) {
                $status = Status::where('type', 'organization_status')
                    ->where('type', 'general')
                    ->where('name', 'active')
                    ->first();
            }

            // Create organization
            $organization = Organization::create([
                'name' => $request->name,
                'type' => $request->type,
                'leader_id' => $user->id, // current user is the leader
                'status_id' => $status->id,
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);

            // Create leader history
            $organization->leaderHistory()->create([
                'user_id' => $user->id,
                'start_date' => now(),
                'reason' => 'initial',
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);

            // Update user fields based on organization type
            if ($request->type === 'family') {
                $user->family_leader = 1;
                $user->family_name = $request->name;
            } elseif ($request->type === 'group') {
                $user->group_leader = 1;
                $user->group_name = $request->name;
            }
            $user->save();

            DB::commit();

            return redirect()->route('admin.dashboard') // or wherever you want
                ->with('success', 'Organization created successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()->withErrors([
                'error' => 'Error creating organization: ' . $e->getMessage()
            ]);
        }
    }
}
