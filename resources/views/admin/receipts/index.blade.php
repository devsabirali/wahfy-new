@extends('admin.layouts.app')

@section('title', 'Receipts')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Receipts</h3>
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
                                    <th>Reference</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($receipts as $receipt)
                                    <tr>
                                        <td>{{ $receipt->id }}</td>
                                        <td>{{ $receipt->user->name ?? 'N/A' }}</td>
                                        <td>{{ $receipt->organization->name ?? 'N/A' }}</td>
                                        <td>{{ $receipt->reference ?? 'N/A' }}</td>
                                        <td>{{ number_format($receipt->amount, 2) }}</td>
                                        <td>
                                            <span class="badge badge-{{ $receipt->status === 'success' ? 'success' : ($receipt->status === 'pending' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($receipt->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $receipt->created_at->format('Y-m-d H:i:s') }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('admin.receipts.show', $receipt) }}" class="btn btn-info btn-sm" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.receipts.edit', $receipt) }}" class="btn btn-primary btn-sm" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.receipts.destroy', $receipt) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm('Are you sure you want to delete this receipt?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No receipts found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $receipts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('sidebar')
    <li class="nav-item">
        <a href="{{ route('admin.receipts.create') }}" class="nav-link">
            <i class="fas fa-plus"></i>
            <span>Add Receipt</span>
        </a>
    </li>
@endsection
