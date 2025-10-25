<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\PaymentReminder;
use App\Models\User;
use App\Models\Organization;
use App\Models\Charge;
use Illuminate\Http\Request;

class PaymentReminderController extends Controller
{
    public function index()
    {
        $paymentReminders = PaymentReminder::with(['user', 'organization', 'charge'])
            ->latest()
            ->paginate(10);
        return view('admin.payment-reminders.index', compact('paymentReminders'));
    }

    public function create()
    {
        $users = User::all();
        $organizations = Organization::all();
        $charges = Charge::all();
        return view('admin.payment-reminders.create', compact('users', 'organizations', 'charges'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'organization_id' => 'required|exists:organizations,id',
            'charge_id' => 'required|exists:charges,id',
            'reminder_date' => 'required|date',
            'due_date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|string',
            'notes' => 'nullable|string'
        ]);

        PaymentReminder::create([
            'user_id' => $request->user_id,
            'organization_id' => $request->organization_id,
            'charge_id' => $request->charge_id,
            'reminder_date' => $request->reminder_date,
            'due_date' => $request->due_date,
            'amount' => $request->amount,
            'status' => $request->status,
            'notes' => $request->notes,
            'created_by' => auth()->id(),
            'updated_by' => auth()->id()
        ]);

        return redirect()->route('admin.payment-reminders.index')
            ->with('success', 'Payment reminder created successfully.');
    }

    public function show(PaymentReminder $paymentReminder)
    {
        $paymentReminder->load(['user', 'organization', 'charge']);
        return view('admin.payment-reminders.show', compact('paymentReminder'));
    }

    public function edit(PaymentReminder $paymentReminder)
    {
        $users = User::all();
        $organizations = Organization::all();
        $charges = Charge::all();
        return view('admin.payment-reminders.edit', compact('paymentReminder', 'users', 'organizations', 'charges'));
    }

    public function update(Request $request, PaymentReminder $paymentReminder)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'organization_id' => 'required|exists:organizations,id',
            'charge_id' => 'required|exists:charges,id',
            'reminder_date' => 'required|date',
            'due_date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|string',
            'notes' => 'nullable|string'
        ]);

        $paymentReminder->update([
            'user_id' => $request->user_id,
            'organization_id' => $request->organization_id,
            'charge_id' => $request->charge_id,
            'reminder_date' => $request->reminder_date,
            'due_date' => $request->due_date,
            'amount' => $request->amount,
            'status' => $request->status,
            'notes' => $request->notes,
            'updated_by' => auth()->id()
        ]);

        return redirect()->route('admin.payment-reminders.index')
            ->with('success', 'Payment reminder updated successfully.');
    }

    public function destroy(PaymentReminder $paymentReminder)
    {
        $paymentReminder->delete();
        return redirect()->route('admin.payment-reminders.index')
            ->with('success', 'Payment reminder deleted successfully.');
    }
}
