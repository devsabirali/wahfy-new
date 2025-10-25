@extends('admin.layouts.app')

@section('title', 'User Activity Logs')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        @php
            $breadcrumbs = [
                ['label' => 'Dashboard', 'url' => '/dashboard'],
                ['label' => 'User Activity Logs', 'url' => '']
            ];
        @endphp
        @include('admin.layouts.page-title', ['breadcrumbs' => $breadcrumbs])
        
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">User Activity Logs List</h4>
                        <a href="">
                             <form action="{{ route('admin.activity-logs.clear') }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to clear all activity logs? This action cannot be undone.')">
                                    <span class="fe fe-trash-2 mr-2"></span> Clear All Logs
                                </button>
                            </form>
                        </a>
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
                                        <th>Activity Type</th>
                                        <th>Module</th>
                                        <th>Action</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($logs as $log)
                                        <tr>
                                            <td>{{ $log->id }}</td>
                                            <td>{{ $log->user->name ?? 'System' }}</td>
                                            <td>{{ ucfirst($log->activity_type) }}</td>
                                            <td>{{ $log->module ?? 'N/A' }}</td>
                                            <td>{{ $log->action ?? 'N/A' }}</td>
                                            <td>
                                                <span class="badge bg-{{ $log->status === 'success' ? 'success' : 'danger' }}">
                                                    {{ ucfirst($log->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                                            <td>
                                                <div class="g-2 d-flex">
                                                    <a href="{{ route('admin.activity-logs.show', $log) }}"
                                                       class="btn text-info btn-sm"
                                                       data-bs-toggle="tooltip"
                                                       title="View">
                                                        <span class="fe fe-eye fs-14"></span>
                                                    </a>
                                                    <form action="{{ route('admin.activity-logs.destroy', $log) }}"
                                                          method="POST"
                                                          style="display:inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="btn text-danger btn-sm"
                                                                data-bs-toggle="tooltip"
                                                                title="Delete"
                                                                onclick="return confirm('Are you sure you want to delete this activity log?')">
                                                            <span class="fe fe-trash-2 fs-14"></span>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">No activity logs found.</td>
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
