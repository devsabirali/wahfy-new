@extends('admin.layouts.app')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        @php
            $breadcrumbs = [
                ['label' => 'Dashboard', 'url' => '/dashboard'],
                ['label' => 'Organizations', 'url' => route('admin.organizations.index')],
                ['label' => $organization->name, 'url' => route('admin.organizations.show', $organization)],
                ['label' => 'Members', 'url' => route('admin.organizations.members.store.index', $organization)],
                ['label' => 'Member Details', 'url' => '']
            ];
        @endphp

        @include('admin.layouts.page-title', ['breadcrumbs' => $breadcrumbs])

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Member Details</h4>
                        <div class="card-tools">
                            <a href="{{ route('admin.organizations.members.store.index', $organization) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Members
                            </a>
                            <a href="{{ route('admin.organizations.members.store.edit', [$organization, $member]) }}" class="btn btn-primary">
                                <i class="fas fa-edit"></i> Edit Member
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Member Information</h5>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Name</th>
                                        <td>{{ $member->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $member->user->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            <span class="badge" style="background-color: {{ $member->status->color }}">
                                                {{ $member->status->name }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Joined At</th>
                                        <td>{{ $member->joined_at->format('F j, Y g:i A') }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h5>Organization Information</h5>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Organization</th>
                                        <td>{{ $organization->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Created By</th>
                                        <td>{{ $member->createdBy->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Created</th>
                                        <td>{{ $member->created_at->format('F j, Y g:i A') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Last Updated</th>
                                        <td>{{ $member->updated_at->format('F j, Y g:i A') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
