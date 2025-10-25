@extends('admin.layouts.app')

@section('title', 'Payment Methods')

@section('content')
<div class="container-fluid">
    @php
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => '/dashboard'],
            ['label' => 'Payment Methods', 'url' => route('admin.incidents.index')],
        ];
    @endphp
    @include('admin.layouts.page-title', ['breadcrumbs' => $breadcrumbs])
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Payment Methods</h3>
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
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($paymentMethods as $method)
                                    <tr>
                                        <td>{{ $method->id }}</td>
                                        <td>{{ $method->name }}</td>
                                        <td>
                                            <span class="badge text-{{ $method->status ? 'success' : 'danger' }}">
                                                {{ $method->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>{{ $method->created_at ? $method->created_at->format('Y-m-d H:i:s') : '-' }}</td>
                                        <td>
                                            <div >
                                                <a href="{{ route('admin.payment-methods.show', $method) }}" class="btn text-info btn-sm" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.payment-methods.edit', $method) }}" class="btn text-primary btn-sm" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.payment-methods.destroy', $method) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn text-danger btn-sm" title="Delete" onclick="return confirm('Are you sure you want to delete this payment method?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No payment methods found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $paymentMethods->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('sidebar')
    <li class="nav-item">
        <a href="{{ route('admin.payment-methods.create') }}" class="nav-link">
            <i class="fas fa-plus"></i>
            <span>Add Payment Method</span>
        </a>
    </li>
@endsection
