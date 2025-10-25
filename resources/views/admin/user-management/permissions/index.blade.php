@extends('admin.layouts.app')

@section('content')
    @php
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => '/dashboard'],
            ['label' => 'Permissions', 'url' => '/permissions'],
        ];
    @endphp

    @include('admin.layouts.page-title', ['breadcrumbs' => $breadcrumbs])

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">Permissions</h3>
                </div>
                <div class="card-body pt-4">
                    <div class="panel panel-primary">
                        <div class="panel-body tabs-menu-body border-0 pt-0">
                            <div class="tab-content">
                                <div class="tab-pane active">
                                    <div class="table-responsive">
                                        <table class="table text-nowrap mb-0 border-0">
                                            <thead>
                                                <tr>
                                                    <th class="bg-transparent border-0">No</th>
                                                    <th class="bg-transparent border-0">Name</th>
                                                    <th class="bg-transparent border-0 text-end">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $groupedPermissions = $permissions->groupBy(function ($item) {
                                                        $parts = explode('-', $item->name);
                                                        return end($parts); // Group by last word
                                                    });

                                                    $counter =
                                                        $permissions->currentPage() * $permissions->perPage() -
                                                        $permissions->perPage();
                                                @endphp

                                                @foreach ($groupedPermissions as $model => $group)
                                                    <tr class="table-primary">
                                                        <td colspan="3" class="p-0">
                                                            <button
                                                                class="btn btn-toggle border-0 d-flex justify-content-between align-items-center w-100 fw-bold text-capitalize px-3 py-2"
                                                                data-bs-toggle="collapse"
                                                                data-bs-target="#collapse-{{ Str::slug($model) }}"
                                                                aria-expanded="false"
                                                                aria-controls="collapse-{{ Str::slug($model) }}">
                                                                <span>{{ $model }} Permissions</span>
                                                                <i class="bi bi-chevron-down collapse-icon"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <tr class="collapse-row">
                                                        <td colspan="3" class="p-0">
                                                            <div class="collapse" id="collapse-{{ Str::slug($model) }}">
                                                                <table class="table table-hover mb-0 border-0">
                                                                    <tbody>
                                                                        @foreach ($group as $index => $key)
                                                                            @php $counter++; @endphp
                                                                            <tr>
                                                                                <td class="text-center" width="50px">
                                                                                    <div class="mt-0 mt-sm-2 d-block">
                                                                                        <h6 class="mb-0 fs-14 fw-semibold">
                                                                                            {{ $counter }}</h6>
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="d-flex">
                                                                                        <div class="mt-0 mt-sm-2 d-block">
                                                                                            <h6
                                                                                                class="mb-0 fs-14 fw-semibold">
                                                                                                {{ $key->name }}</h6>
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td width="120px">
                                                                                    <div class="d-flex gap-2">
                                                                                        @if(hasPermissionOrRole('update-permissions'))
                                                                                            <a href="{{ route('admin.permissions.edit', $key->id) }}"
                                                                                                class="btn text-primary btn-sm"
                                                                                                data-bs-toggle="tooltip"
                                                                                                title="Edit">
                                                                                                <span class="fe fe-edit fs-14"></span>
                                                                                            </a>
                                                                                        @endif
                                                                                        @if(hasPermissionOrRole('delete-permissions'))
                                                                                            <form method="POST"
                                                                                                action="{{ route('admin.permissions.destroy', $key->id) }}"
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
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{-- @include('admin.layouts.pagination', ['items' => $permissions]) --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
