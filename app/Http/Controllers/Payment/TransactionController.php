<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Organization;
use App\Models\Status;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('status')
            ->latest()
            ->paginate(10);
        return view('admin.transactions.index', compact('transactions'));
    }

    public function create()
    {
        $organizations = Organization::all();
        $statuses = Status::where('type', 'transaction_status')->get();
        return view('admin.transactions.create', compact('organizations', 'statuses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'type' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'transaction_date' => 'required|date',
            'status_id' => 'required|exists:statuses,id'
        ]);

        Transaction::create([
            'organization_id' => $request->organization_id,
            'type' => $request->type,
            'amount' => $request->amount,
            'description' => $request->description,
            'transaction_date' => $request->transaction_date,
            'status_id' => $request->status_id,
            'created_by' => auth()->id(),
            'updated_by' => auth()->id()
        ]);

        return redirect()->route('admin.transactions.index')
            ->with('success', 'Transaction created successfully.');
    }

    public function show(Transaction $transaction)
    {
        $transaction->load(['organization', 'status']);
        return view('admin.transactions.show', compact('transaction'));
    }

    public function edit(Transaction $transaction)
    {
        $organizations = Organization::all();
        $statuses = Status::where('type', 'transaction_status')->get();
        return view('admin.transactions.edit', compact('transaction', 'organizations', 'statuses'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'type' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'transaction_date' => 'required|date',
            'status_id' => 'required|exists:statuses,id'
        ]);

        $transaction->update([
            'organization_id' => $request->organization_id,
            'type' => $request->type,
            'amount' => $request->amount,
            'description' => $request->description,
            'transaction_date' => $request->transaction_date,
            'status_id' => $request->status_id,
            'updated_by' => auth()->id()
        ]);

        return redirect()->route('admin.transactions.index')
            ->with('success', 'Transaction updated successfully.');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return redirect()->route('admin.transactions.index')
            ->with('success', 'Transaction deleted successfully.');
    }
}
