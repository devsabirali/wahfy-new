@extends('admin.layouts.app')

@section('content')
    @php
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => '/dashboard'],
            ['label' => 'Roles', 'url' => '/roles']
        ];
    @endphp

    @include('admin.layouts.page-title', ['breadcrumbs' => $breadcrumbs])

    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="row">
                @if(session('success'))
                    <div class="alert alert-info">
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    </div>
                @endif
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            </div>
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Roles</h3>
                    {{-- @can('role-create')
                    <a href="{{ route('admin.roles.create') }}" class="btn btn-primary waves-effect waves-light mb-2">
                        <i class="mdi mdi-plus"></i>
                    </a>
                    @endcan --}}
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
                                                        <!-- <th class="bg-transparent border-bottom-0">Permissions</th> -->
                                                        <th class="bg-transparent border-bottom-0" style="width: 10%;">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($roles as $index => $key)
                                                        <tr class="border-bottom">
                                                            <td class="text-center">
                                                                <div class="mt-0 mt-sm-2 d-block">
                                                                    <h6 class="mb-0 fs-14 fw-semibold">
                                                                        {{ $roles->currentPage() * $roles->perPage() - $roles->perPage() + $index + 1 }}
                                                                    </h6>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex">
                                                                    <div class="mt-0 mt-sm-2 d-block">
                                                                        <h6 class="mb-0 fs-14 fw-semibold">
                                                                            {{ $key->name }}
                                                                        </h6>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <!-- <td>
                                                                <div class="d-flex">
                                                                    <div class="mt-0 mt-sm-2 d-block">
                                                                        <h6 class="mb-0 fs-14 fw-semibold">
                                                                            @foreach($key->permissions as $permission)
                                                                                <span class="badge bg-info">{{ $permission->name }}</span>
                                                                            @endforeach
                                                                        </h6>
                                                                    </div>
                                                                </div>
                                                            </td> -->
                                                            <td>
                                                                <div class="d-flex gap-3">
                                                                    @if(hasPermissionOrRole('update-roles'))
                                                                        <a href="{{ route('admin.roles.edit', $key->id) }}"
                                                                            class="btn text-primary btn-sm"
                                                                            data-bs-toggle="tooltip"
                                                                            title="Edit">
                                                                            <span class="fe fe-edit fs-14"></span>
                                                                        </a>
                                                                    @endif
                                                                    @if(hasPermissionOrRole('delete-roles'))
                                                                        <form method="POST"
                                                                            action="{{ route('admin.roles.destroy', $key->id) }}"
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
                                            {{ $roles->links() }}
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
