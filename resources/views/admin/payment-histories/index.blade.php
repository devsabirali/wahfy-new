@extends('admin.layouts.app')

@section('title', 'Payment Histories')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Payment Histories</h3>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Organization</th>
                                    <th>Payment</th>
                                    <th>Amount</th>
                                    <th>Payment Method</th>
                                    <th>Status</th>
                                    <th>Paid At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($paymentHistories as $history)
                                    <tr>
                                        <td>{{ $history->id }}</td>
                                        <td>{{ $history->user->name ?? 'N/A' }}</td>
                                        <td>{{ $history->organization->name ?? 'N/A' }}</td>
                                        <td>{{ $history->payment->reference ?? 'N/A' }}</td>
                                        <td>{{ number_format($history->amount, 2) }}</td>
                                        <td>{{ ucfirst($history->payment_method) }}</td>
                                        <td>
                                            <span class="badge text-{{
                                                (is_object($history->status) && $history->status->name === 'success') || $history->status === 'success' ? 'success' :
                                                ((is_object($history->status) && $history->status->name === 'pending') || $history->status === 'pending' ? 'warning' : 'danger')
                                            }}">
                                                {{ is_object($history->status) && $history->status->name ? ucfirst($history->status->name) : (is_string($history->status) ? ucfirst($history->status) : '-') }}
                                            </span>
                                        </td>

                                        <td>{{ $history->paid_at ? $history->paid_at->format('Y-m-d H:i:s') : 'N/A' }}</td>
                                        <td>
                                            <div class="btn-group">
                                                @if(hasPermissionOrRole('read-payment_histories'))
                                                <a href="{{ route('admin.payment-histories.show', $history) }}" class="btn btn-sm" title="View">
                                                    <i class="fas fa-eye text-info"></i>
                                                </a>
                                                @endif
                                                @if(hasPermissionOrRole('update-payment_histories'))
                                                <a href="{{ route('admin.payment-histories.edit', $history) }}" class="btn btn-sm" title="Edit">
                                                    <i class="fas fa-edit text-primary"></i>
                                                </a>
                                                @endif
                                                @if(hasPermissionOrRole('delete-payment_histories'))
                                                <form action="{{ route('admin.payment-histories.destroy', $history) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm" title="Delete" onclick="return confirm('Are you sure you want to delete this payment history?')">
                                                        <i class="fas fa-trash text-danger"></i>
                                                    </button>
                                                </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No payment histories found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $paymentHistories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('sidebar')
    @if(hasPermissionOrRole('create-payment_histories'))
    <li class="nav-item">
        <a href="{{ route('admin.payment-histories.create') }}" class="nav-link">
            <i class="fas fa-plus"></i>
            <span>Add Payment History</span>
        </a>
    </li>
    @endif
@endsection
