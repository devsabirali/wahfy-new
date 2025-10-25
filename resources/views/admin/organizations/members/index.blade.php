@extends('admin.layouts.app')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        @php
            $breadcrumbs = [
                ['label' => 'Dashboard', 'url' => '/dashboard'],
                ['label' => 'Organizations', 'url' => route('admin.organizations.index')],
                ['label' => $organization->name, 'url' => route('admin.organizations.show', $organization)],
                ['label' => 'Members', 'url' => '']
            ];
        @endphp

        @include('admin.layouts.page-title', ['breadcrumbs' => $breadcrumbs])

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Members of {{ $organization->name }}</h4>
                        <a href="{{ route('admin.organizations.members.create', $organization) }}" class="btn btn-primary btn-sm">
                            <i class="mdi mdi-plus"></i> Add Member
                        </a>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Status</th>
                                        <th>Joined At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($members as $member)
                                        <tr>
                                            <td>{{ $member->user->name }}</td>
                                            <td>{{ $member->user->email }}</td>
                                            <td>{{ $member->user->phone }}</td>
                                           <td>
                                                <span class="badge {{ $member->status->name == 'Active' ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $member->status->name }}
                                                </span>
                                            </td>
                                            <td>{{ $member->membership_start_date->format('M d, Y H:i') }}</td>
                                            <td>
                                                <div role="group">
                                                    <a href="{{ route('admin.organizations.members.edit', [$organization, $member]) }}"
                                                       class="btn text-primary btn-sm">
                                                        <span class="fe fe-edit fs-14"></span>
                                                    </a>
                                                    <form action="{{ route('admin.organizations.members.destroy', [$organization, $member]) }}"
                                                          method="POST"
                                                          class="d-inline"
                                                          onsubmit="return confirm('Are you sure you want to remove this member?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn text-danger btn-sm">
                                                             <span class="fe fe-trash-2 fs-14"></span>
                                                        </button>
                                                    </form>
                                                </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No members found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $members->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
