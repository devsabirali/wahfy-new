@extends('admin.layouts.app')

@section('title', 'Activity Log Details')

@section('content')
<div class="page-header">
    <div class="page-leftheader">
        <h4 class="page-title mb-0">Activity Log Details</h4>
    </div>
    <div class="page-rightheader ml-auto d-lg-flex d-none">
        @if(hasPermissionOrRole('read-user_activity_log'))
        <a href="{{ route('admin.activity-logs.index') }}" class="btn btn-primary">
            <i class="fe fe-arrow-left mr-2"></i> Back to List
        </a>
        @endif
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Activity Log #{{ $userActivityLog->id }}</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 200px;">User</th>
                                <td>{{ $userActivityLog->user->name ?? 'System' }}</td>
                            </tr>
                            <tr>
                                <th>Activity Type</th>
                                <td>{{ ucfirst($userActivityLog->activity_type) }}</td>
                            </tr>
                            <tr>
                                <th>Module</th>
                                <td>{{ $userActivityLog->module ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Action</th>
                                <td>{{ $userActivityLog->action ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    <span class="badge badge-{{ $userActivityLog->status === 'success' ? 'success' : 'danger' }}">
                                        {{ ucfirst($userActivityLog->status) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td>{{ $userActivityLog->description }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 200px;">IP Address</th>
                                <td>{{ $userActivityLog->ip_address }}</td>
                            </tr>
                            <tr>
                                <th>User Agent</th>
                                <td>{{ $userActivityLog->user_agent }}</td>
                            </tr>
                            <tr>
                                <th>Created</th>
                                <td>{{ $userActivityLog->created_at->format('Y-m-d H:i:s') }}</td>
                            </tr>
                            <tr>
                                <th>Last Updated</th>
                                <td>{{ $userActivityLog->updated_at->format('Y-m-d H:i:s') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                @if($userActivityLog->details)
                    <div class="row mt-4">
                        <div class="col-12">
                            <h4>Additional Details</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Key</th>
                                            <th>Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($userActivityLog->details as $key => $value)
                                            <tr>
                                                <td>{{ ucfirst(str_replace('_', ' ', $key)) }}</td>
                                                <td>
                                                    @if(is_array($value))
                                                        <pre>{{ json_encode($value, JSON_PRETTY_PRINT) }}</pre>
                                                    @else
                                                        {{ $value }}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="row mt-4">
                    <div class="col-12">
                        @if(hasPermissionOrRole('delete-user_activity_log'))
                        <form action="{{ route('admin.activity-logs.destroy', $userActivityLog) }}"
                              method="POST"
                              class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="btn btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this activity log?')">
                                <i class="fe fe-trash-2 mr-2"></i> Delete Log
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
