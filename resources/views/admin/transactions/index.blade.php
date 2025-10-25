@extends('admin.layouts.app')

@section('title', 'Transactions')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Transactions</h3>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Organization</th>
                                    <th>Reference</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Type</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions as $transaction)
                                    <tr>
                                        <td>{{ $transaction->id }}</td>
                                        <td>{{ $transaction->payment->user->name ?? '--'}}</td>
                                        <td>{{ $transaction->payment->user->organizations->name ?? '--' }}</td>
                                        <td>{{ $transaction->reference ?? 'N/A' }}</td>
                                        <td>{{ number_format($transaction->amount, 2) }}</td>
                                        <td>
                                            <span class="badge text-{{ $transaction->status === 'success' ? 'success' : ($transaction->status === 'pending' ? 'warning' : 'danger') }}">
                                                {{ $transaction->status->name }}
                                            </span>
                                        </td>
                                        <td>{{  $transaction->type->name ?? 'N/A' }}</td>
                                        <td>{{ $transaction->created_at->format('Y-m-d H:i:s') }}</td>
                                        <td>
                                            <div>
                                                @if(hasPermissionOrRole('read-transactions'))
                                                    <a href="{{ route('admin.transactions.show', $transaction) }}" class="btn text-info btn-sm" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @endif
                                                @if(hasPermissionOrRole('update-transactions'))
                                                    <a href="{{ route('admin.transactions.edit', $transaction) }}" class="btn text-primary btn-sm" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endif
                                                @if(hasPermissionOrRole('delete-transactions'))
                                                    <form action="{{ route('admin.transactions.destroy', $transaction) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn text-danger btn-sm" title="Delete" onclick="return confirm('Are you sure you want to delete this transaction?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No transactions found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $transactions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('sidebar')
    @if(hasPermissionOrRole('create-transactions'))
        <li class="nav-item">
            <a href="{{ route('admin.transactions.create') }}" class="nav-link">
                <i class="fas fa-plus"></i>
                <span>Add Transaction</span>
            </a>
        </li>
    @endif
@endsection
