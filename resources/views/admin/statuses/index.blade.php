@extends('admin.layouts.app')

@section('title', 'Status')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        @php
            $breadcrumbs = [
                ['label' => 'Dashboard', 'url' => '/dashboard'],
                ['label' => 'Status', 'url' => '']
            ];
        @endphp
        @include('admin.layouts.page-title', ['breadcrumbs' => $breadcrumbs])

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @php
            // Group statuses by type, if type does not end with '_status', consider it as model type
            $groupedStatuses = $statuses->groupBy(function($status) {
                return str_ends_with($status->type, '_status') ? $status->type : $status->type . ' (model)';
            });
        @endphp

        @foreach($groupedStatuses as $type => $group)
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">{{ ucwords(str_replace('_', ' ', $type)) }}</h5>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped align-middle">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Created By</th>
                            <th>Updated By</th>
                            <th>Date & Time</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($group as $status)
                        <tr>
                            <td>{{ $status->id }}</td>
                            <td>{{ $status->name }}</td>
                            <td>{{ $status->createdBy->name ?? 'N/A' }}</td>
                            <td>{{ $status->updatedBy->name ?? 'N/A' }}</td>
                            <td>{{ $status->created_at->format('Y-m-d H:i:s') }}</td>
                            <td>
                                <div class="g-2 d-flex">
                                    <a href="{{ route('admin.statuses.show', $status) }}" class="btn text-info btn-sm" title="View">
                                        <span class="fe fe-eye fs-14"></span>
                                    </a>
                                    <a href="{{ route('admin.statuses.edit', $status) }}" class="btn text-primary btn-sm" title="Edit">
                                        <span class="fe fe-edit fs-14"></span>
                                    </a>
                                    <form action="{{ route('admin.statuses.destroy', $status) }}" method="POST" style="display:inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn text-danger btn-sm" title="Delete" onclick="return confirm('Are you sure you want to delete this status?')">
                                            <span class="fe fe-trash-2 fs-14"></span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No statuses found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
