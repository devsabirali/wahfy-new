@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    @php
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => '/dashboard'],
            ['label' => 'Payments', 'url' => route('admin.payments.index')],
            ['label' => 'Payment Details'],
        ];
    @endphp
    @include('admin.layouts.page-title', ['breadcrumbs' => $breadcrumbs])

    <div class="row">
        <div class="col-12">
            <div class="card">

                {{-- Card Header --}}
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Payment Details</h3>
                    <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>

                {{-- Card Body --}}
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>User</th>
                            <td>{{ $payment->user->name }}</td>
                        </tr>
                        <tr>
                            <th>Charge</th>
                            <td>{{ $payment->charge->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Amount</th>
                            <td>{{ number_format($payment->amount, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Payment Type</th>
                            <td>{{ ucfirst($payment->payment_type) }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="badge text-{{ $payment->status->name === 'Completed' ? 'success' : 'warning' }}">
                                    {{ $payment->status->name }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Payment Date</th>
                            <td>{{ $payment->transaction->payment_date }}</td>
                        </tr>
                        <tr>
                            <th>Transaction ID</th>
                            <td>{{ $payment->transaction->id ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Created At</th>
                            <td>{{ $payment->created_at->format('d M Y, h:i A') }}</td>
                        </tr>
                        <tr>
                            <th>Updated At</th>
                            <td>{{ $payment->updated_at->format('d M Y, h:i A') }}</td>
                        </tr>
                    </table>
                </div>

                {{-- Card Footer --}}
                <div class="card-footer d-flex justify-content-end">
                    @if(hasPermissionOrRole('update-payments'))
                        <a href="{{ route('admin.payments.edit', $payment) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    @endif
                    @if(hasPermissionOrRole('delete-payments'))
                        <form action="{{ route('admin.payments.destroy', $payment) }}"
                              method="POST"
                              class="d-inline ms-2"
                              onsubmit="return confirm('Are you sure you want to delete this payment?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
