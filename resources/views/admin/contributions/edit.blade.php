@extends('admin.layouts.app')

@section('title', 'Edit Contribution')

@section('content')
<div class="page-header">
    <div class="page-leftheader">
        <h4 class="page-title mb-0">Edit Contribution</h4>
    </div>
    <div class="page-rightheader ml-auto d-lg-flex d-none">
        @if(hasPermissionOrRole('read-contribution'))
        <a href="{{ route('admin.contributions.index') }}" class="btn btn-secondary">
            <i class="fe fe-arrow-left mr-2"></i> Back to List
        </a>
        @endif
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit Contribution</h3>
            </div>
            <div class="card-body">
                @if(hasPermissionOrRole('update-contribution'))
                <form action="{{ route('admin.contributions.update', $contribution) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="user_id">User <span class="text-danger">*</span></label>
                        <select name="user_id" id="user_id" class="form-control @error('user_id') is-invalid @enderror" required>
                            <option value="">Select User</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ (old('user_id', $contribution->user_id) == $user->id) ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="organization_id">Organization <span class="text-danger">*</span></label>
                        <select name="organization_id" id="organization_id" class="form-control @error('organization_id') is-invalid @enderror" required>
                            <option value="">Select Organization</option>
                            @foreach($organizations as $organization)
                                <option value="{{ $organization->id }}"
                                    {{ (old('organization_id', $contribution->organization_id) == $organization->id) ? 'selected' : '' }}>
                                    {{ $organization->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('organization_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="amount">Amount <span class="text-danger">*</span></label>
                        <input type="number"
                               name="amount"
                               id="amount"
                               class="form-control @error('amount') is-invalid @enderror"
                               value="{{ old('amount', $contribution->amount) }}"
                               step="0.01"
                               min="0"
                               required>
                        @error('amount')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="payment_method_id">Payment Method <span class="text-danger">*</span></label>
                        <select name="payment_method_id" id="payment_method_id" class="form-control @error('payment_method_id') is-invalid @enderror" required>
                            <option value="">Select Payment Method</option>
                            @foreach($paymentMethods as $method)
                                <option value="{{ $method->id }}"
                                    {{ (old('payment_method_id', $contribution->payment_method_id) == $method->id) ? 'selected' : '' }}>
                                    {{ $method->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('payment_method_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="status">Status <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                            <option value="">Select Status</option>
                            <option value="pending" {{ (old('status', $contribution->status) == 'pending') ? 'selected' : '' }}>Pending</option>
                            <option value="completed" {{ (old('status', $contribution->status) == 'completed') ? 'selected' : '' }}>Completed</option>
                            <option value="failed" {{ (old('status', $contribution->status) == 'failed') ? 'selected' : '' }}>Failed</option>
                        </select>
                        @error('status')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="payment_date">Payment Date <span class="text-danger">*</span></label>
                        <input type="date"
                               name="payment_date"
                               id="payment_date"
                               class="form-control @error('payment_date') is-invalid @enderror"
                               value="{{ old('payment_date', $contribution->payment_date->format('Y-m-d')) }}"
                               required>
                        @error('payment_date')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description"
                                  id="description"
                                  class="form-control @error('description') is-invalid @enderror"
                                  rows="3">{{ old('description', $contribution->description) }}</textarea>
                        @error('description')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fe fe-save mr-2"></i> Update Contribution
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
