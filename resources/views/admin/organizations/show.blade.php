@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <!-- Header -->
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Organization Details</h3>
                    <a href="{{ route('admin.organizations.index') }}" class="btn btn-default btn-sm">
                        <i class="mdi mdi-arrow-left"></i> Back to List
                    </a>
                </div>

                <!-- Body -->
                <div class="card-body">
                    <div class="row">
                        <!-- Basic Info -->
                        <div class="col-md-6">
                            <h4>Basic Information</h4>
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 200px;">Name</th>
                                    <td>{{ $organization->name }}</td>
                                </tr>
                                <tr>
                                    <th>Type</th>
                                    <td>{{ ucfirst($organization->type) }}</td>
                                </tr>
                                <tr>
                                    <th>Leader</th>
                                    <td>{{ $organization->leader->name }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge badge-{{ $organization->status->name === 'Active' ? 'success' : 'danger' }}">
                                            {{ $organization->status->name }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Created</th>
                                    <td>{{ $organization->created_at->format('Y-m-d H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Last Updated</th>
                                    <td>{{ $organization->updated_at->format('Y-m-d H:i') }}</td>
                                </tr>
                            </table>
                        </div>

                        <!-- Leader History -->
                        <div class="col-md-6">
                            <h4>Leader History</h4>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Leader</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Reason</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($organization->leaderHistory as $history)
                                        <tr>
                                            <td>{{ $history->user->name }}</td>
                                            <td>{{ $history->start_date->format('Y-m-d') }}</td>
                                            <td>{{ $history->end_date ? $history->end_date->format('Y-m-d') : 'Current' }}</td>
                                            <td>{{ ucfirst($history->reason) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Members -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="mb-0">Members</h4>
                                <a href="{{ route('admin.organizations.members.create', $organization) }}" class="btn btn-primary btn-sm">
                                    <i class="mdi mdi-plus"></i> Add Member
                                </a>
                            </div>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Membership Start Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($organization->members as $member)
                                        <tr>
                                            <td>{{ $member->user->name }}</td>
                                            <td>
                                                <span class="badge badge-{{ $member->status->name === 'Active' ? 'success' : 'danger' }}">
                                                    {{ $member->status->name }}
                                                </span>
                                            </td>
                                            <td>{{ $member->membership_start_date->format('Y-m-d') }}</td>
                                            <td>
                                                <div>
                                                    <a href="{{ route('admin.organizations.members.edit', [$organization, $member]) }}"
                                                       class="btn text-primary btn-sm">
                                                        <i class="fe fe-edit fs-14"></i>
                                                    </a>
                                                    <form action="{{ route('admin.members.destroy', [$organization, $member]) }}"
                                                          method="POST"
                                                          class="d-inline"
                                                          onsubmit="return confirm('Are you sure you want to remove this member?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn text-danger btn-sm">
                                                            <i class="fe fe-trash-2 fs-14"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <a href="{{ route('admin.organizations.edit', $organization) }}" class="btn btn-primary btn-sm me-2">
                                <i class="mdi mdi-pencil"></i> Edit Organization
                            </a>
                            <form action="{{ route('admin.organizations.destroy', $organization) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Are you sure you want to delete this organization?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="mdi mdi-delete"></i> Delete Organization
                                </button>
                            </form>
                        </div>
                    </div>

                </div> <!-- /card-body -->
            </div>
        </div>
    </div>
</div>
@endsection
