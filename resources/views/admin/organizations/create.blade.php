@extends('admin.layouts.app')

@section('title', 'Create Organization')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        @php
            $breadcrumbs = [
                ['label' => 'Dashboard', 'url' => '/dashboard'],
                ['label' => 'Organizations', 'url' => route('admin.organizations.index')],
                ['label' => 'Create Organization', 'url' => '']
            ];
        @endphp
        @include('admin.layouts.page-title', ['breadcrumbs' => $breadcrumbs])
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Create Organization</h4>
                        <div class="card-tools">
                            <a href="{{ route('admin.organizations.index') }}" class="btn btn-light btn-sm">
                                <span class="fe fe-arrow-left"></span> Back to List
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('admin.organizations.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Organization Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="type" class="form-label">Organization Type</label>
                                    <select class="form-control @error('type') is-invalid @enderror" id="type" name="type" required>
                                        <option value="">Select Type</option>
                                        <option value="family" {{ old('type') == 'family' ? 'selected' : '' }}>Family</option>
                                        <option value="group" {{ old('type') == 'group' ? 'selected' : '' }}>Group</option>
                                    </select>
                                    @error('type')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="leader_id" class="form-label">Leader</label>
                                    <select class="form-control @error('leader_id') is-invalid @enderror" id="leader_id" name="leader_id" required>
                                        <option value="">Select Leader</option>
                                        @foreach($leaders as $leader)
                                            <option value="{{ $leader->id }}" {{ old('leader_id') == $leader->id ? 'selected' : '' }}>{{ $leader->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('leader_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="status_id" class="form-label">Status</label>
                                    <select class="form-control @error('status_id') is-invalid @enderror" id="status_id" name="status_id" required>
                                        <option value="">Select Status</option>
                                        @foreach($statuses as $status)
                                            <option value="{{ $status->id }}" {{ old('status_id') == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('status_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.organizations.index') }}" class="btn btn-light">Cancel</a>
                                <button type="submit" class="btn btn-primary">
                                    <span class="fe fe-save"></span> Create Organization
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
