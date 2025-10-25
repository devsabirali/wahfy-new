@extends('admin.layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            @php
                $breadcrumbs = [
                    ['label' => 'Dashboard', 'url' => '/dashboard'],
                    ['label' => 'Payment Methods', 'url' => route('admin.payment-methods.index')],
                    ['label' => 'Payment Method Details', 'url' => '']
                ];
            @endphp

            @include('admin.layouts.page-title', ['breadcrumbs' => $breadcrumbs])

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">Payment Method Details</h4>
                            <div>
                                <a href="{{ route('admin.payment-methods.edit', $paymentMethod) }}"
                                    class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.payment-methods.destroy', $paymentMethod) }}" method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Are you sure you want to delete this payment method?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th style="width: 200px;">Name</th>
                                            <td>{{ $paymentMethod->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td>
                                                <span
                                                    class="badge text-{{ $paymentMethod->is_active ? 'success' : 'danger' }}">
                                                    {{ $paymentMethod->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th style="width: 200px;">Created By</th>
                                            <td>{{ $paymentMethod->createdBy->name ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Created</th>
                                            <td>{{ $paymentMethod->created_at->format('M d, Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Updated By</th>
                                            <td>{{ $paymentMethod->updatedBy->name ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Updated At</th>
                                            <td>{{ $paymentMethod->updated_at->format('M d, Y H:i') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="mt-4">
                                <a href="{{ route('admin.payment-methods.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Back to List
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
