<?php

namespace App\Http\Controllers\AuditLog;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index()
    {
        $auditLogs = AuditLog::with(['user', 'createdBy', 'updatedBy'])
            ->latest()
            ->paginate(10);
        return view('admin.audit-logs.index', compact('auditLogs'));
    }

    public function show(AuditLog $auditLog)
    {
        $auditLog->load(['user', 'createdBy', 'updatedBy']);
        return view('admin.audit-logs.show', compact('auditLog'));
    }

    public function destroy(AuditLog $auditLog)
    {
        $auditLog->delete();
        return redirect()->route('admin.audit-logs.index')
            ->with('success', 'Audit log deleted successfully.');
    }
}
