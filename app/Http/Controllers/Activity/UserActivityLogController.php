<?php

namespace App\Http\Controllers\Activity;

use App\Http\Controllers\Controller;
use App\Models\UserActivityLog;
use Illuminate\Http\Request;

class UserActivityLogController extends Controller
{
    public function index()
    {
        $logs = UserActivityLog::with(['user'])
            ->latest()
            ->paginate(20);

        return view('admin.activity-logs.index', compact('logs'));
    }

    public function show(UserActivityLog $userActivityLog)
    {
        $userActivityLog->load(['user']);
        return view('admin.activity-logs.show', compact('userActivityLog'));
    }

    public function destroy(UserActivityLog $userActivityLog)
    {
        $userActivityLog->delete();

        return redirect()->route('admin.activity-logs.index')
            ->with('success', 'Activity log deleted successfully.');
    }

    public function clear()
    {
        UserActivityLog::truncate();

        return redirect()->route('admin.activity-logs.index')
            ->with('success', 'All activity logs have been cleared.');
    }
}
