@extends('admin.layouts.app')

@section('content')
    @php
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => '/dashboard'],
            ['label' => 'Users', 'url' => route('admin.users.index')]
        ];
    @endphp

    @include('admin.layouts.page-title', ['breadcrumbs' => $breadcrumbs])

    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">All Users</h3>
                </div>
                <div class="card-body pt-4">
                    <div class="grid-margin">
                        <div class="panel panel-primary">
                            <div class="panel-body tabs-menu-body border-0 pt-0">
                                <div class="tab-content">
                                    <div class="tab-pane active">
                                        <div class="table-responsive">
                                            <table class="table table-bordered text-nowrap mb-0">
                                                <thead class="border-top">
                                                    <tr>
                                                        <th class="bg-transparent border-bottom-0" style="width: 5%;">No</th>
                                                        <th class="bg-transparent border-bottom-0">Name</th>
                                                        <th class="bg-transparent border-bottom-0">Email</th>
                                                        <th class="bg-transparent border-bottom-0">Phone</th>
                                                        <th class="bg-transparent border-bottom-0">Status</th>
                                                        <th class="bg-transparent border-bottom-0">Roles</th>
                                                        <!-- <th class="bg-transparent border-bottom-0">Permissions</th> -->
                                                        <th class="bg-transparent border-bottom-0" style="width: 12%;">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($users as $index => $user)
                                                        <tr class="border-bottom">
                                                            <td class="text-center">
                                                                <h6 class="mb-0 fs-14 fw-semibold">
                                                                    {{ $users->currentPage() * $users->perPage() - $users->perPage() + $index + 1 }}
                                                                </h6>
                                                            </td>
                                                            <td>
                                                                <h6 class="mb-0 fs-14 fw-semibold">
                                                                    {{ $user->getFullName() }}
                                                                </h6>
                                                            </td>
                                                            <td>{{ $user->email }}</td>
                                                            <td>{{ $user->phone }}</td>
                                                            <td>
                                                                <span class="badge bg-{{ $user->payment_status == 'paid' ? 'success' : 'warning' }}">
                                                                    {{ ucfirst($user->payment_status) }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                @foreach($user->roles as $role)
                                                                    <span class="badge bg-primary">{{ $role->name }}</span>
                                                                @endforeach
                                                            </td>
                                                            <!-- <td>
                                                                @foreach($user->permissions as $permission)
                                                                    <span class="badge bg-info">{{ $permission->name }}</span>
                                                                @endforeach
                                                            </td> -->
                                                            <td>
                                                                <div class="g-2 d-flex">
                                                                    @if(hasPermissionOrRole('update-users'))
                                                                        <a href="{{ route('admin.users.edit', $user->id) }}"
                                                                            class="btn text-primary btn-sm"
                                                                            data-bs-toggle="tooltip"
                                                                            title="Edit">
                                                                            <span class="fe fe-edit fs-14"></span>
                                                                        </a>
                                                                    @endif
                                                                    @if(hasPermissionOrRole('delete-users'))
                                                                        <form method="POST"
                                                                            action="{{ route('admin.users.destroy', $user->id) }}"
                                                                            style="display: inline-block">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit"
                                                                                class="btn text-danger btn-sm"
                                                                                data-bs-toggle="tooltip"
                                                                                title="Delete"
                                                                                onclick="return confirm('Are you sure?')">
                                                                                <span class="fe fe-trash-2 fs-14"></span>
                                                                            </button>
                                                                        </form>
                                                                    @endif
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="mt-3">
                                            {{ $users->links() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
