@extends('admin.layouts.app')

@section('title', 'Organizations')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        @php
            $breadcrumbs = [
                ['label' => 'Dashboard', 'url' => '/dashboard'],
                ['label' => 'Organizations', 'url' => '']
            ];
        @endphp
        @include('admin.layouts.page-title', ['breadcrumbs' => $breadcrumbs])
        <div class="row">
            <div class="col-12">
                <div class="card">
                     <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Organizations</h4>
                        <a href="{{ route('admin.organizations.create') }}" class="btn btn-primary btn-sm">
                            <span class="fe fe-plus"></span> Add Organization
                        </a>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-striped align-middle">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Leader</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($organizations as $organization)
                                        <tr>
                                            <td>{{ $organization->name }}</td>
                                            <td>{{ ucfirst($organization->type) }}</td>
                                            <td>{{ $organization->leader->name }}</td>
                                            <td>
                                                <span class="badge bg-{{ $organization->status->name === 'Active' ? 'success' : 'danger' }}">
                                                    {{ $organization->status->name }}
                                                </span>
                                            </td>
                                            <td>{{ $organization->created_at->format('Y-m-d H:i') }}</td>
                                            <td>
                                                <div class="g-2 d-flex">
                                                    <a href="{{ route('admin.organizations.members.index', $organization) }}" class="btn text-success btn-sm" data-bs-toggle="tooltip" title="View Members">
                                                        <span class="fe fe-users fs-14"></span>
                                                    </a>
                                                    <a href="{{ route('admin.organizations.show', $organization) }}" class="btn text-info btn-sm" data-bs-toggle="tooltip" title="View Details">
                                                        <span class="fe fe-eye fs-14"></span>
                                                    </a>
                                                    <a href="{{ route('admin.organizations.edit', $organization) }}" class="btn text-primary btn-sm" data-bs-toggle="tooltip" title="Edit">
                                                        <span class="fe fe-edit fs-14"></span>
                                                    </a>
                                                    <form action="{{ route('admin.organizations.destroy', $organization) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Are you sure you want to delete this organization?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn text-danger btn-sm" data-bs-toggle="tooltip" title="Delete">
                                                            <span class="fe fe-trash-2 fs-14"></span>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $organizations->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
