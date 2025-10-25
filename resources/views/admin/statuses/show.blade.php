@extends('admin.layouts.app')

@section('title', 'View Status')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            @php
                $breadcrumbs = [
                    ['label' => 'Dashboard', 'url' => '/dashboard'],
                    ['label' => 'Status', 'url' => route('admin.statuses.index')],
                    ['label' => 'View Status', 'url' => '']
                ];
            @endphp

            @include('admin.layouts.page-title', ['breadcrumbs' => $breadcrumbs])

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Status Details</h4>
                            <a href="{{ route('admin.statuses.edit', $status) }}" class="btn btn-primary btn-sm">
                                <i class="fe fe-edit"></i> Edit Status
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>ID</th>
                                            <td>{{ $status->id }}</td>
                                        </tr>
                                        <tr>
                                            <th>Name</th>
                                            <td>{{ $status->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Type</th>
                                            <td>{{ $status->type }}</td>
                                        </tr>
                                        <tr>
                                            <th>Created By</th>
                                            <td>{{ $status->createdBy->name ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Updated By</th>
                                            <td>{{ $status->updatedBy->name ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Created At</th>
                                            <td>{{ $status->created_at->format('Y-m-d H:i:s') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Updated At</th>
                                            <td>{{ $status->updated_at->format('Y-m-d H:i:s') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
