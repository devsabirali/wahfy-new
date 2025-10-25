@extends('admin.layouts.app')

@section('title', 'Create Payment')

@section('content')
<div class="container-fluid">
    @php
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => '/dashboard'],
            ['label' => 'Payments', 'url' => route('admin.incidents.index')],
        ];
    @endphp
    @include('admin.layouts.page-title', ['breadcrumbs' => $breadcrumbs])

    <div class="row">
        <div class="col-12">
            <div class="card">

                {{-- Card Header --}}
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Create Payment</h3>
                    @if(hasPermissionOrRole('read-payments'))
                        <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    @endif
                </div>

                {{-- Card Body --}}
                <div class="card-body">

                    {{-- Validation Errors --}}
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Payment Form --}}
                    <form action="{{ route('admin.payments.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            {{-- Transaction ID --}}
                            <div class="col-md-6 mb-3">
                                <label for="transaction_id" class="form-label">Transaction ID</label>
                                <input type="text"
                                       class="form-control @error('transaction_id') is-invalid @enderror"
                                       id="transaction_id"
                                       name="transaction_id"
                                       value="{{ old('transaction_id') }}"
                                       required>
                                @error('transaction_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- User --}}
                            <div class="col-md-6 mb-3">
                                <label for="user_id" class="form-label">User</label>
                                <select class="form-control @error('user_id') is-invalid @enderror"
                                        id="user_id"
                                        name="user_id"
                                        required>
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

                            {{-- Charge --}}
                            <div class="col-md-6 mb-3">
                                <label for="charge_id" class="form-label">Charge</label>
                                <select class="form-control @error('charge_id') is-invalid @enderror"
                                        id="charge_id"
                                        name="charge_id"
                                        required>
                                    <option value="">Select Charge</option>
                                    @foreach($charges as $charge)
                                        <option value="{{ $charge->id }}" {{ old('charge_id') == $charge->id ? 'selected' : '' }}>
                                            {{ $charge->name }} ({{ number_format($charge->amount, 2) }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('charge_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Payment Method --}}
                            <div class="col-md-6 mb-3">
                                <label for="payment_method_id" class="form-label">Payment Method</label>
                                <select class="form-control @error('payment_method_id') is-invalid @enderror"
                                        id="payment_method_id"
                                        name="payment_method_id"
                                        required>
                                    <option value="">Select Payment Method</option>
                                    @foreach($paymentMethods as $method)
                                        <option value="{{ $method->id }}" {{ old('payment_method_id') == $method->id ? 'selected' : '' }}>
                                            {{ $method->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('payment_method_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Amount --}}
                            <div class="col-md-6 mb-3">
                                <label for="amount" class="form-label">Amount</label>
                                <input type="number"
                                       class="form-control @error('amount') is-invalid @enderror"
                                       id="amount"
                                       name="amount"
                                       value="{{ old('amount') }}"
                                       step="0.01"
                                       min="0"
                                       required>
                                @error('amount')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Payment Type --}}
                            <div class="col-md-6 mb-3">
                                <label for="payment_type" class="form-label">Payment Type</label>
                                <select class="form-control @error('payment_type') is-invalid @enderror"
                                        id="payment_type"
                                        name="payment_type"
                                        required>
                                    <option value="">Select Type</option>
                                    <option value="membership" {{ old('payment_type') == 'membership' ? 'selected' : '' }}>Membership</option>
                                    <option value="contribution" {{ old('payment_type') == 'contribution' ? 'selected' : '' }}>Contribution</option>
                                </select>
                                @error('payment_type')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Status --}}
                            <div class="col-md-6 mb-3">
                                <label for="status_id" class="form-label">Status</label>
                                <select class="form-control @error('status_id') is-invalid @enderror"
                                        id="status_id"
                                        name="status_id"
                                        required>
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

                            {{-- Payment Date --}}
                            <div class="col-md-6 mb-3">
                                <label for="payment_date" class="form-label">Payment Date</label>
                                <input type="datetime-local"
                                       class="form-control @error('payment_date') is-invalid @enderror"
                                       id="payment_date"
                                       name="payment_date"
                                       value="{{ old('payment_date', date('Y-m-d\TH:i')) }}"
                                       required>
                                @error('payment_date')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Submit Button --}}
                        <div class="text-end mt-3">
                            @if(hasPermissionOrRole('create-payments'))
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Create Payment
                                </button>
                            @endif
                        </div>

                    </form>
                    {{-- End Form --}}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
