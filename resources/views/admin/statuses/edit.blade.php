@extends('admin.layouts.app')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        @php
            $breadcrumbs = [
                ['label' => 'Dashboard', 'url' => '/dashboard'],
                ['label' => 'Status', 'url' => route('admin.statuses.index')],
                ['label' => 'Edit Status', 'url' => '']
            ];
        @endphp

        @include('admin.layouts.page-title', ['breadcrumbs' => $breadcrumbs])

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Status: {{ $status->name }}</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.statuses.update', $status) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', $status->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('type') is-invalid @enderror"
                                    id="type" name="type" value="{{ old('type', $status->type) }}" required>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="text-end">
                                <a href="{{ route('admin.statuses.index') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Update Status</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
