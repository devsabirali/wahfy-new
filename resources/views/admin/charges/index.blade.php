@extends('admin.layouts.app')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        @php
            $breadcrumbs = [
                ['label' => 'Dashboard', 'url' => '/dashboard'],
                ['label' => 'Charges', 'url' => '']
            ];
        @endphp

        @include('admin.layouts.page-title', ['breadcrumbs' => $breadcrumbs])

        <div class="row">
            <div class="col-12">
                <div class="card">
                     <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Charges</h4>
                        <div class="card-tools">
                            <a href="{{ route('admin.charges.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Add Charge
                            </a>
                        </div>
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

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($charges as $charge)
                                        <tr>
                                            <td>{{ $charge->name }}</td>
                                            <td>{{ ucfirst($charge->type) }}</td>
                                            <td>
                                                    {{ number_format($charge->amount, 2) }}
                                            </td>
                                            <td>
                                                <span class="badge {{ $charge->is_active ? 'text-success' : 'text-danger' }}">
                                                    {{ $charge->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td>{{ $charge->createdBy->name }}</td>
                                            <td>{{ $charge->created_at->format('M d, Y H:i') }}</td>
                                            <td>
                                                <div  role="group">
                                                    <a href="{{ route('admin.charges.show', $charge) }}"
                                                       class="btn text-info btn-sm" title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.charges.edit', $charge) }}"
                                                       class="btn text-primary btn-sm" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.charges.destroy', $charge) }}"
                                                          method="POST"
                                                          class="d-inline"
                                                          onsubmit="return confirm('Are you sure you want to delete this charge?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn text-danger btn-sm" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No charges found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $charges->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('sidebar')
    <li class="nav-item">
        <a href="{{ route('admin.charges.create') }}" class="nav-link">
            <i class="fas fa-plus"></i>
            <span>Add Charge</span>
        </a>
    </li>
@endsection
