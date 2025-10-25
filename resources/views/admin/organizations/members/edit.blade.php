@extends('admin.layouts.app')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        @php
            $breadcrumbs = [
                ['label' => 'Dashboard', 'url' => '/dashboard'],
                ['label' => 'Organizations', 'url' => route('admin.organizations.index')],
                ['label' => $organization->name, 'url' => route('admin.organizations.show', $organization)],
                ['label' => 'Members', 'url' => route('admin.organizations.members.index', $organization)],
                ['label' => 'Edit Member', 'url' => '']
            ];
        @endphp

        @include('admin.layouts.page-title', ['breadcrumbs' => $breadcrumbs])

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Member in {{ $organization->name }}</h4>
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

                        <form action="{{ route('admin.organizations.members.update', [$organization, $member]) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="user_id" class="form-label">User <span class="text-danger">*</span></label>
                                <select class="form-select @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
                                    <option value="">Select User</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id', $member->user_id) == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="status_id" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status_id') is-invalid @enderror" id="status_id" name="status_id" required>
                                    <option value="">Select Status</option>
                                    @foreach($statuses as $status)
                                        <option value="{{ $status->id }}" {{ old('status_id', $member->status_id) == $status->id ? 'selected' : '' }}>
                                            {{ $status->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('status_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="membership_start_date" class="form-label">Membership Start Date <span class="text-danger">*</span></label>
                                <input type="datetime-local" class="form-control @error('membership_start_date') is-invalid @enderror"
                                    id="membership_start_date" name="membership_start_date"
                                    value="{{ old('membership_start_date', $member->membership_start_date->format('Y-m-d\TH:i')) }}" required>
                                @error('membership_start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="text-end">
                                <a href="{{ route('admin.organizations.members.index', $organization) }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Update Member</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
