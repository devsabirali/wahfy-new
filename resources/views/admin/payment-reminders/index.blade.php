@extends('admin.layouts.app')

@section('title', 'Payment Reminders')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Payment Reminders</h3>
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
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Due Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($paymentReminders as $reminder)
                                    <tr>
                                        <td>{{ $reminder->id }}</td>
                                        <td>{{ $reminder->user->name ?? 'N/A' }}</td>
                                        <td>{{ $reminder->organization->name ?? 'N/A' }}</td>
                                        <td>{{ number_format($reminder->amount, 2) }}</td>
                                        <td>
                                            <span class="badge badge-{{ $reminder->status === 'sent' ? 'success' : 'warning' }}">
                                                {{ ucfirst($reminder->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $reminder->due_date ? $reminder->due_date->format('Y-m-d') : 'N/A' }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('admin.payment-reminders.show', $reminder) }}" class="btn btn-info btn-sm" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.payment-reminders.edit', $reminder) }}" class="btn btn-primary btn-sm" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.payment-reminders.destroy', $reminder) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm('Are you sure you want to delete this payment reminder?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No payment reminders found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $paymentReminders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('sidebar')
    <li class="nav-item">
        <a href="{{ route('admin.payment-reminders.create') }}" class="nav-link">
            <i class="fas fa-plus"></i>
            <span>Add Payment Reminder</span>
        </a>
    </li>
@endsection
