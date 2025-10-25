<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\PaymentHistory;
use App\Models\Payment;
use App\Models\Status;
use Illuminate\Http\Request;

class PaymentHistoryController extends Controller
{
    public function index()
    {
        $paymentHistories = PaymentHistory::with(['payment', 'status'])
            ->latest()
            ->paginate(10);
        return view('admin.payment-histories.index', compact('paymentHistories'));
    }

    public function create()
    {
        $payments = Payment::all();
        $statuses = Status::where('type', 'payment_status')->get();
        return view('admin.payment-histories.create', compact('payments', 'statuses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'payment_id' => 'required|exists:payments,id',
            'status_id' => 'required|exists:statuses,id',
            'notes' => 'nullable|string'
        ]);

        PaymentHistory::create([
            'payment_id' => $request->payment_id,
            'status_id' => $request->status_id,
            'notes' => $request->notes,
            'created_by' => auth()->id(),
            'updated_by' => auth()->id()
        ]);

        return redirect()->route('admin.payment-histories.index')
            ->with('success', 'Payment history created successfully.');
    }

    public function show(PaymentHistory $paymentHistory)
    {
        $paymentHistory->load(['payment', 'status']);
        return view('admin.payment-histories.show', compact('paymentHistory'));
    }

    public function edit(PaymentHistory $paymentHistory)
    {
        $payments = Payment::all();
        $statuses = Status::where('type', 'payment_status')->get();
        return view('admin.payment-histories.edit', compact('paymentHistory', 'payments', 'statuses'));
    }

    public function update(Request $request, PaymentHistory $paymentHistory)
    {
        $request->validate([
            'payment_id' => 'required|exists:payments,id',
            'status_id' => 'required|exists:statuses,id',
            'notes' => 'nullable|string'
        ]);

        $paymentHistory->update([
            'payment_id' => $request->payment_id,
            'status_id' => $request->status_id,
            'notes' => $request->notes,
            'updated_by' => auth()->id()
        ]);

        return redirect()->route('admin.payment-histories.index')
            ->with('success', 'Payment history updated successfully.');
    }

    public function destroy(PaymentHistory $paymentHistory)
    {
        $paymentHistory->delete();
        return redirect()->route('admin.payment-histories.index')
            ->with('success', 'Payment history deleted successfully.');
    }
}
