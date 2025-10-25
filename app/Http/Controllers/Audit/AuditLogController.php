<?php

namespace App\Http\Controllers\Audit;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index()
    {
        $logs = AuditLog::with(['user'])
            ->latest()
            ->paginate(20);

        return view('admin.audit-logs.index', compact('logs'));
    }

    public function show(AuditLog $auditLog)
    {
        $auditLog->load(['user']);
        return view('admin.audit-logs.show', compact('auditLog'));
    }

    public function destroy(AuditLog $auditLog)
    {
        $auditLog->delete();

        return redirect()->route('admin.audit-logs.index')
            ->with('success', 'Audit log deleted successfully.');
    }

    public function clear()
    {
        AuditLog::truncate();

        return redirect()->route('admin.audit-logs.index')
            ->with('success', 'All audit logs have been cleared.');
    }
}
