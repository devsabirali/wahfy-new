<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Charge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChargeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $charges = Charge::with(['createdBy', 'updatedBy'])
            ->latest()
            ->paginate(10);

        return view('admin.charges.index', compact('charges'));
    }

    public function create()
    {
        return view('admin.charges.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:membership,admin_fee',
            'amount' => 'required|numeric|min:0',
            'is_active' => 'boolean'
        ]);

        // try {
            DB::beginTransaction();

            $charge = new Charge([
                'name' => $request->name,
                'type' => $request->type,
                'amount' => $request->amount,
                'is_active' => $request->is_active ?? true,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id()
            ]);

            $charge->save();

            DB::commit();

            return redirect()
                ->route('admin.charges.index')
                ->with('success', 'Charge added successfully.');
        // } catch (\Exception $e) {
        //     DB::rollBack();
        //     return back()
        //         ->withInput()
        //         ->with('error', 'Error adding charge: ' . $e->getMessage());
        // }
    }

    public function show(Charge $charge)
    {
        return view('admin.charges.show', compact('charge'));
    }

    public function edit(Charge $charge)
    {
        return view('admin.charges.edit', compact('charge'));
    }

    public function update(Request $request, Charge $charge)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:membership,admin_fee',
            'amount' => 'required|numeric|min:0',
            'is_active' => 'boolean'
        ]);

        try {
            $charge->update([
                'name' => $request->name,
                'type' => $request->type,
                'amount' => $request->amount,
                'is_active' => $request->is_active ?? true,
                'updated_by' => Auth::id()
            ]);

            return redirect()
                ->route('admin.charges.index')
                ->with('success', 'Charge updated successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error updating charge: ' . $e->getMessage());
        }
    }

    public function destroy(Charge $charge)
    {
        try {
            $charge->delete();
            return redirect()
                ->route('admin.charges.index')
                ->with('success', 'Charge deleted successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error deleting charge: ' . $e->getMessage());
        }
    }
}
