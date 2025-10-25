@extends('admin.layouts.app')

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
                <div class="card-header">
                    <h3 class="card-title">Payments</h3>
                    {{-- <div class="card-tools">
                        <a href="{{ route('admin.payments.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Add Payment
                        </a>
                    </div> --}}
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Charge</th>
                                <th>Amount</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Payment Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments as $payment)
                                <tr>
                                    <td>{{ $payment->user->name }}</td>
                                    <td>{{ $payment->charge->name ?? 'N/A' }}</td>
                                    <td>{{ number_format($payment->amount, 2) }}</td>
                                    <td>{{ ucfirst($payment->payment_type) }}</td>
                                    <td>
                                        <span class="badge text-{{ $payment->status->name === 'Completed' ? 'success' : 'warning' }}">
                                            {{ $payment->status->name }}
                                        </span>
                                    </td>
                                    <td>{{ $payment->transaction->payment_date}}</td>
                                    <td>
                                        <div>
                                            @if(hasPermissionOrRole('read-payments'))
                                                <a href="{{ route('admin.payments.show', $payment) }}"
                                                   class="btn text-info btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            @endif
                                            @if(hasPermissionOrRole('update-payments'))
                                                <a href="{{ route('admin.payments.edit', $payment) }}"
                                                   class="btn text-primary btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endif
                                            @if(hasPermissionOrRole('delete-payments'))
                                                <form action="{{ route('admin.payments.destroy', $payment) }}"
                                                      method="POST"
                                                      class="d-inline"
                                                      onsubmit="return confirm('Are you sure you want to delete this payment?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn text-danger btn-sm">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $payments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
