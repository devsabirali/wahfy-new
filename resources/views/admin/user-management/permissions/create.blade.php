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
                        <div class="card-header">
                            <h4 class="card-title mb-0">Create New Permission</h4>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('admin.permissions.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Permission Name</label>
                                            <input class="form-control @error('name') is-invalid @enderror"
                                                type="text" id="name" name="name" placeholder="Enter permission name">
                                            @error('name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="card-footer bg-transparent border-top">
                            <div class="d-flex justify-content-end gap-2">
                                <button type="reset" class="btn btn-light">Reset</button>
                                @if(hasPermissionOrRole('create-permissions'))
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                @endif
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
