@extends('admin.layouts.app')

@section('title', 'Create Event')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        @php
            $breadcrumbs = [
                ['label' => 'Dashboard', 'url' => '/dashboard'],
                ['label' => 'Events', 'url' => route('admin.incidents.index')],
                ['label' => 'Create Event', 'url' => '']
            ];
        @endphp
        @include('admin.layouts.page-title', ['breadcrumbs' => $breadcrumbs])

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Create Event</h4>
                        <div class="card-tools">
                            <a href="{{ route('admin.incidents.index') }}" class="btn btn-light btn-sm">
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

                        {{-- Probation Status Information --}}
                        @if($probationStatus['status'] !== 'completed')
                            <div class="alert alert-{{ $probationStatus['status'] === 'not_started' ? 'warning' : 'info' }} mb-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Probation Status:</strong> {{ $probationStatus['message'] }}
                                        @if($probationStatus['start_date'])
                                            <br><small class="text-muted">
                                                Started: {{ $probationStatus['start_date']->format('M d, Y') }} |
                                                Ends: {{ $probationStatus['end_date']->format('M d, Y') }}
                                            </small>
                                        @endif
                                    </div>
                                    @if($probationStatus['remaining_days'] !== null && $probationStatus['remaining_days'] > 0)
                                        <div class="text-right">
                                            <span class="badge badge-{{ $probationStatus['remaining_days'] <= 30 ? 'warning' : 'primary' }}">
                                                {{ $probationStatus['remaining_days'] }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <form action="{{ route('admin.incidents.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="user_id" class="form-label">User</label>
                                    <select class="form-control @error('user_id') is-invalid @enderror"
                                        id="user_id" name="user_id" required>
                                        <option value="">Select User</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="deceased_name" class="form-label">Deceased Name</label>
                                    <input type="text" class="form-control @error('deceased_name') is-invalid @enderror"
                                        id="deceased_name" name="deceased_name" value="{{ old('deceased_name') }}" required>
                                    @error('deceased_name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="date_of_death" class="form-label">Date of Death</label>
                                    <input type="date" class="form-control @error('date_of_death') is-invalid @enderror"
                                        id="date_of_death" name="date_of_death" value="{{ old('date_of_death') }}" required>
                                    @error('date_of_death')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="type" class="form-label">Event Type</label>
                                    <select class="form-control @error('type') is-invalid @enderror" id="type" name="type" required>
                                        <option value="">Select Type</option>
                                        @foreach($types as $type)
                                            <option value="{{ $type }}" {{ old('type') == $type ? 'selected' : '' }}>
                                                {{ ucfirst($type) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('type')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>


                                <div class="col-md-6 mb-3">
                                    <label for="amount" class="form-label">Amount</label>
                                    <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror"
                                        id="amount" name="amount" value="{{ old('amount') }}" required>
                                    @error('amount')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror"
                                        id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
                                    @error('description')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                @if($isAdmin)
                                <div class="col-md-6 mb-3">
                                    <label for="status_id" class="form-label">Status</label>
                                    <select class="form-control @error('status_id') is-invalid @enderror"
                                        id="status_id" name="status_id" required>
                                        <option value="">Select Status</option>
                                        @foreach($statuses as $status)
                                            <option value="{{ $status->id }}" {{ old('status_id') == $status->id ? 'selected' : '' }}>
                                                {{ $status->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('status_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="verified_by" class="form-label">Verified By</label>
                                    <select class="form-control @error('verified_by') is-invalid @enderror"
                                        id="verified_by" name="verified_by">
                                        <option value="">Select Verifier</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ old('verified_by') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">Optional - Leave empty if not verified yet</small>
                                    @error('verified_by')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                @else
                                <div class="col-md-12 mb-3">
                                    <div class="alert alert-info">
                                        <strong>Note:</strong> Your incident will be created with "Pending" status and will be reviewed by an administrator.
                                    </div>
                                </div>
                                @endif

                                <div class="col-md-6 mb-3">
                                    <label for="thumbnail_path" class="form-label">Thumbnail Image</label>
                                    <input type="file" class="form-control @error('thumbnail_path') is-invalid @enderror"
                                        id="thumbnail_path" name="thumbnail_path" accept="image/jpeg,image/png,image/jpg">
                                    <small class="form-text text-muted">Maximum file size: 2MB</small>
                                    @error('thumbnail_path')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="images" class="form-label">Additional Images</label>
                                    <input type="file" class="form-control @error('images.*') is-invalid @enderror"
                                        id="images" name="images[]" multiple accept="image/jpeg,image/png,image/jpg">
                                    <small class="form-text text-muted">You can select multiple images. Maximum file size: 2MB per image.</small>
                                    @error('images.*')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                @if(hasPermissionOrRole('read-incident'))
                                    <a href="{{ route('admin.incidents.index') }}" class="btn btn-light">Cancel</a>
                                @endif
                                @if(hasPermissionOrRole('create-incident'))
                                    <button type="submit" class="btn btn-primary">
                                        <span class="fe fe-save"></span> Create Event
                                    </button>
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
