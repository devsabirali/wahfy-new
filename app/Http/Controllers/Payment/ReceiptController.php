<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Receipt;
use App\Models\Payment;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    public function index()
    {
        $receipts = Receipt::with('payment')
            ->latest()
            ->paginate(10);
        return view('admin.receipts.index', compact('receipts'));
    }

    public function create()
    {
        $payments = Payment::all();
        return view('admin.receipts.create', compact('payments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'payment_id' => 'required|exists:payments,id',
            'receipt_number' => 'required|string|max:255|unique:receipts',
            'amount' => 'required|numeric|min:0',
            'issue_date' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        Receipt::create([
            'payment_id' => $request->payment_id,
            'receipt_number' => $request->receipt_number,
            'amount' => $request->amount,
            'issue_date' => $request->issue_date,
            'notes' => $request->notes,
            'created_by' => auth()->id(),
            'updated_by' => auth()->id()
        ]);

        return redirect()->route('admin.receipts.index')
            ->with('success', 'Receipt created successfully.');
    }

    public function show(Receipt $receipt)
    {
        $receipt->load('payment');
        return view('admin.receipts.show', compact('receipt'));
    }

    public function edit(Receipt $receipt)
    {
        $payments = Payment::all();
        return view('admin.receipts.edit', compact('receipt', 'payments'));
    }

    public function update(Request $request, Receipt $receipt)
    {
        $request->validate([
            'payment_id' => 'required|exists:payments,id',
            'receipt_number' => 'required|string|max:255|unique:receipts,receipt_number,' . $receipt->id,
            'amount' => 'required|numeric|min:0',
            'issue_date' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        $receipt->update([
            'payment_id' => $request->payment_id,
            'receipt_number' => $request->receipt_number,
            'amount' => $request->amount,
            'issue_date' => $request->issue_date,
            'notes' => $request->notes,
            'updated_by' => auth()->id()
        ]);

        return redirect()->route('admin.receipts.index')
            ->with('success', 'Receipt updated successfully.');
    }

    public function destroy(Receipt $receipt)
    {
        $receipt->delete();
        return redirect()->route('admin.receipts.index')
            ->with('success', 'Receipt deleted successfully.');
    }
}
