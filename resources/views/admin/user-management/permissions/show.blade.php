@extends('admin.layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
               @php
                    $breadcrumbs = [
                        ['label' => 'Dashboard', 'url' => '/dashboard'],
                        ['label' => 'Permissions', 'url' => '/permissions']
                    ];
                @endphp

                @include('admin.layouts.page-title', ['breadcrumbs' => $breadcrumbs])

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-md-12 text-end">
                                    @if(hasPermissionOrRole('create-permissions'))
                                        <a href="{{ route('admin.permissions.create') }}"
                                            class="btn btn-primary waves-effect waves-light mb-2 "><i
                                                class="mdi mdi-plus"></i></a>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <table id="datatable" class="table table-sm table-bordered dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th class="align-middle" width="5%">No</th>
                                                <th class="align-middle"> Name </th>
                                                <th class="align-middle" width="5%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($permissions as $index => $key)
                                                <tr>
                                                    <td>
                                                        {{ $permissions->currentPage() * $permissions->perPage() - $permissions->perPage() + $index + 1 }}
                                                    </td>
                                                    <td>{{ $key->name }}</td>
                                                    <td>
                                                        <div class="d-flex gap-3">
                                                            @if(hasPermissionOrRole('update-permissions'))
                                                                <a href="{{ route('admin.permissions.edit', $key->id) }}"
                                                                    class="text-success"><i
                                                                        class="mdi mdi-pencil font-size-18"></i></a>
                                                            @endif
                                                            @if(hasPermissionOrRole('delete-permissions'))
                                                                <form method="post" style="margin: 0px !important"
                                                                    action="{{ route('admin.permissions.destroy', $key->id) }}"
                                                                    style="display: inline-block">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        style="background-color:white;border:none;"
                                                                        class="text-danger"
                                                                        onclick="return confirm('Are you sure you want to delete?')"><i
                                                                            class="mdi mdi-delete font-size-18"></i></button>
                                                                </form>
                                                            @endif
                                                            <div>
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                                @include('layouts.backend.pagination', ['items' => $permissions])
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
