@extends('admin.layouts.app')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        @php
            $breadcrumbs = [
                ['label' => 'Dashboard', 'url' => '/dashboard'],
                ['label' => 'Members', 'url' => route('admin.organizations.members.index')],
                ['label' => 'View Member', 'url' => '']
            ];
        @endphp

        @include('admin.layouts.page-title', ['breadcrumbs' => $breadcrumbs])

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Member Details</h4>
                        <div class="card-tools">
                            <a href="{{ route('admin.organizations.members.edit', $member) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-edit"></i> Edit Member
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tr>
                                        <th style="width: 200px;">Organization</th>
                                        <td>{{ $member->organization->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>User</th>
                                        <td>{{ $member->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Role</th>
                                        <td>{{ $member->role }}</td>
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
                                        <td>{{ $member->membership_start_date->format('M d, Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Created By</th>
                                        <td>{{ $member->createdBy->name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Created</th>
                                        <td>{{ $member->created_at->format('M d, Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Updated By</th>
                                        <td>{{ $member->updatedBy->name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Updated At</th>
                                        <td>{{ $member->updated_at->format('M d, Y H:i') }}</td>
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
