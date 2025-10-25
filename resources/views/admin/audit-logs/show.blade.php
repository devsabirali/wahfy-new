@extends('admin.layouts.app')

@section('title', 'View Audit Log')

@section('content')
<div class="page-header">
    <div class="page-leftheader">
        <h4 class="page-title mb-0">View Audit Log</h4>
    </div>
    <div class="page-rightheader ml-auto d-lg-flex d-none">
        @if(hasPermissionOrRole('read-audit_log'))
        <a href="{{ route('admin.audit-logs.index') }}" class="btn btn-secondary">
            <i class="fe fe-arrow-left mr-2"></i> Back to List
        </a>
        @endif
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Audit Log Details</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>User</label>
                            <p class="form-control-static">
                                {{ $auditLog->user->name ?? 'System' }}
                            </p>
                        </div>

                        <div class="form-group">
                            <label>Action</label>
                            <p class="form-control-static">
                                <span class="badge badge-{{ $auditLog->action === 'created' ? 'success' : ($auditLog->action === 'updated' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($auditLog->action) }}
                                </span>
                            </p>
                        </div>

                        <div class="form-group">
                            <label>Model</label>
                            <p class="form-control-static">
                                @if($auditLog->model_type)
                                    {{ class_basename($auditLog->model_type) }} #{{ $auditLog->model_id }}
                                @else
                                    N/A
                                @endif
                            </p>
                        </div>

                        <div class="form-group">
                            <label>IP Address</label>
                            <p class="form-control-static">
                                {{ $auditLog->ip_address ?? 'N/A' }}
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>User Agent</label>
                            <p class="form-control-static">
                                {{ $auditLog->user_agent ?? 'N/A' }}
                            </p>
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <p class="form-control-static">
                                {{ $auditLog->description ?? 'No description provided' }}
                            </p>
                        </div>

                        <div class="form-group">
                            <label>Created</label>
                            <p class="form-control-static">
                                {{ $auditLog->created_at->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                    </div>
                </div>

                @if($auditLog->old_values || $auditLog->new_values)
                    <div class="row mt-4">
                        <div class="col-12">
                            <h4>Changes</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Field</th>
                                            <th>Old Value</th>
                                            <th>New Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($auditLog->new_values ?? [] as $key => $newValue)
                                            <tr>
                                                <td>{{ ucfirst(str_replace('_', ' ', $key)) }}</td>
                                                <td>{{ $auditLog->old_values[$key] ?? 'N/A' }}</td>
                                                <td>{{ $newValue }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="mt-4">
                    @if(hasPermissionOrRole('delete-audit_log'))
                    <form action="{{ route('admin.audit-logs.destroy', $auditLog) }}"
                          method="POST"
                          class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="btn btn-danger"
                                onclick="return confirm('Are you sure you want to delete this audit log?')">
                            <i class="fe fe-trash mr-2"></i> Delete Log
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
