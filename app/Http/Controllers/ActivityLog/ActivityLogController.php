<?php

namespace App\Http\Controllers\ActivityLog;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index()
    {
        $activityLogs = ActivityLog::with(['user', 'createdBy', 'updatedBy'])
            ->latest()
            ->paginate(10);
        return view('admin.activity-logs.index', compact('activityLogs'));
    }

    public function show(ActivityLog $activityLog)
    {
        $activityLog->load(['user', 'createdBy', 'updatedBy']);
        return view('admin.activity-logs.show', compact('activityLog'));
    }

    public function destroy(ActivityLog $activityLog)
    {
        $activityLog->delete();
        return redirect()->route('admin.activity-logs.index')
            ->with('success', 'Activity log deleted successfully.');
    }
}
