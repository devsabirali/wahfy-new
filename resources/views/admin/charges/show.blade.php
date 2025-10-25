@extends('admin.layouts.app')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        @php
            $breadcrumbs = [
                ['label' => 'Dashboard', 'url' => '/dashboard'],
                ['label' => 'Charges', 'url' => route('admin.charges.index')],
                ['label' => 'Charge Details', 'url' => '']
            ];
        @endphp

        @include('admin.layouts.page-title', ['breadcrumbs' => $breadcrumbs])

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Charge Details</h4>
                        <div class="card-tools">
                            <a href="{{ route('admin.charges.edit', $charge) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('admin.charges.destroy', $charge) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Are you sure you want to delete this charge?');">
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
                                        <td>{{ $charge->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Type</th>
                                        <td>{{ ucfirst(str_replace('_', ' ', $charge->type)) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Amount</th>
                                        <td>${{ number_format($charge->amount, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            <span class="badge badge-{{ $charge->is_active ? 'success' : 'danger' }}">
                                                {{ $charge->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tr>
                                        <th style="width: 200px;">Created By</th>
                                        <td>{{ $charge->createdBy->name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Created</th>
                                        <td>{{ $charge->created_at->format('M d, Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Updated By</th>
                                        <td>{{ $charge->updatedBy->name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Updated At</th>
                                        <td>{{ $charge->updated_at->format('M d, Y H:i') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('admin.charges.index') }}" class="btn btn-secondary">
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
