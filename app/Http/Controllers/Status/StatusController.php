<?php

namespace App\Http\Controllers\Status;

use App\Http\Controllers\Controller;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class StatusController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        $statuses = Status::with(['createdBy', 'updatedBy'])->latest()->paginate(500);
        return view('admin.statuses.index', compact('statuses'));
    }

    public function create(): View
    {
        return view('admin.statuses.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('statuses')->where(function ($query) use ($request) {
                    return $query->where('type', $request->type);
                })
            ],
            'type' => 'required|string|max:255'
        ]);

        $status = Status::create([
            'name' => $request->name,
            'type' => $request->type,
            'created_by' => Auth::id()
        ]);

        return redirect()->route('admin.statuses.index')
            ->with('success', 'Status created successfully.');
    }

    public function show(Status $status): View
    {
        return view('admin.statuses.show', compact('status'));
    }

    public function edit(Status $status): View
    {
        return view('admin.statuses.edit', compact('status'));
    }

    public function update(Request $request, Status $status): RedirectResponse
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('statuses')->where(function ($query) use ($request) {
                    return $query->where('type', $request->type);
                })->ignore($status->id)
            ],
            'type' => 'required|string|max:255'
        ]);

        $status->update([
            'name' => $request->name,
            'type' => $request->type,
            'updated_by' => Auth::id()
        ]);

        return redirect()->route('admin.statuses.index')
            ->with('success', 'Status updated successfully.');
    }

    public function destroy(Status $status): RedirectResponse
    {
        // Check if status is being used
        if ($status->organizations()->exists() ||
            $status->payments()->exists() ||
            $status->contributions()->exists() ||
            $status->organizationMembers()->exists()) {
            return redirect()->route('admin.statuses.index')
                ->with('error', 'Cannot delete status as it is being used.');
        }

        $status->delete();

        return redirect()->route('admin.statuses.index')
            ->with('success', 'Status deleted successfully.');
    }
}
