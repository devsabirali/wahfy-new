@extends('admin.layouts.app')

@section('title', 'Audit Logs')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        @php
            $breadcrumbs = [
                ['label' => 'Dashboard', 'url' => '/dashboard'],
                ['label' => 'Audit Logs', 'url' => '']
            ];
        @endphp
        @include('admin.layouts.page-title', ['breadcrumbs' => $breadcrumbs])
        <div class="row mb-3">
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Audit Logs List</h4>
                        @if(hasPermissionOrRole('delete-audit_log'))
                        <a href="">
                             <form action="{{ route('admin.audit-logs.clear') }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to clear all audit logs? This action cannot be undone.')">
                                    <span class="fe fe-trash-2 mr-2"></span> Clear All Logs
                                </button>
                            </form>
                        </a>
                        @endif
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table text-nowrap align-middle">
                                <thead class="thead-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>User</th>
                                        <th>Action</th>
                                        <th>Model</th>
                                        <th>IP Address</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($logs as $log)
                                        <tr>
                                            <td>{{ $log->id }}</td>
                                            <td>{{ $log->user->name ?? 'System' }}</td>
                                            <td>
                                                <span class="badge bg-{{ $log->action === 'created' ? 'success' : ($log->action === 'updated' ? 'warning' : 'danger') }}">
                                                    {{ ucfirst($log->action) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($log->model_type)
                                                    {{ class_basename($log->model_type) }} #{{ $log->model_id }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>{{ $log->ip_address ?? 'N/A' }}</td>
                                            <td>{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                                            <td>
                                                <div class="g-2 d-flex">
                                                    @if(hasPermissionOrRole('read-audit_log'))
                                                    <a href="{{ route('admin.audit-logs.show', $log) }}"
                                                       class="btn text-info btn-sm"
                                                       data-bs-toggle="tooltip"
                                                       title="View">
                                                        <span class="fe fe-eye fs-14"></span>
                                                    </a>
                                                    @endif
                                                    @if(hasPermissionOrRole('delete-audit_log'))
                                                    <form action="{{ route('admin.audit-logs.destroy', $log) }}"
                                                          method="POST"
                                                          style="display:inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="btn text-danger btn-sm"
                                                                data-bs-toggle="tooltip"
                                                                title="Delete"
                                                                onclick="return confirm('Are you sure you want to delete this audit log?')">
                                                            <span class="fe fe-trash-2 fs-14"></span>
                                                        </button>
                                                    </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No audit logs found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $logs->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
