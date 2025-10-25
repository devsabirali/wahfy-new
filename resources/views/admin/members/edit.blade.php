@extends('admin.layouts.app')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        @php
            $breadcrumbs = [
                ['label' => 'Dashboard', 'url' => '/dashboard'],
                ['label' => 'Members', 'url' => route('admin.organizations.members.index')],
                ['label' => 'Edit Member', 'url' => '']
            ];
        @endphp

        @include('admin.layouts.page-title', ['breadcrumbs' => $breadcrumbs])

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Organization Member</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.organizations.members.update', $member) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="organization_id" class="form-label">Organization <span class="text-danger">*</span></label>
                                <select class="form-select @error('organization_id') is-invalid @enderror" id="organization_id" name="organization_id" required>
                                    <option value="">Select Organization</option>
                                    @foreach($organizations as $organization)
                                        <option value="{{ $organization->id }}" {{ (old('organization_id', $member->organization_id) == $organization->id) ? 'selected' : '' }}>
                                            {{ $organization->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('organization_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="user_id" class="form-label">User <span class="text-danger">*</span></label>
                                <select class="form-select @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
                                    <option value="">Select User</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ (old('user_id', $member->user_id) == $user->id) ? 'selected' : '' }}>
                                            {{ $user->name }}
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
                                        <option value="{{ $status->id }}" {{ (old('status_id', $member->status_id) == $status->id) ? 'selected' : '' }}>
                                            {{ $status->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('status_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- <div class="mb-3">
                                <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('role') is-invalid @enderror"
                                    id="role" name="role" value="{{ old('role', $member->role) }}" required>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div> --}}

                            <div class="mb-3">
                                <label for="membership_start_date" class="form-label">Joined At <span class="text-danger">*</span></label>
                                <input type="datetime-local" class="form-control @error('membership_start_date') is-invalid @enderror"
                                    id="membership_start_date" name="membership_start_date"
                                    value="{{ old('membership_start_date', $member->membership_start_date->format('Y-m-d\TH:i')) }}" required>
                                @error('membership_start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="text-end">
                                <a href="{{ route('admin.organizations.members.index') }}" class="btn btn-secondary">Cancel</a>
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
