@extends('admin.layouts.app')

@section('title', 'Contributions')

@section('content')
<div class="page-header">
    <div class="page-leftheader">
        <h4 class="page-title mb-0">Contributions</h4>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Contributions List</h3>
                {{-- @if(auth()->user()->hasRole('admin') && isset($statusOptions))
                <div class="card-options">
                    <form method="GET" class="d-inline">
                        <select name="status" class="form-control form-control-sm">
                            <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Status</option>
                            @foreach($statusOptions as $status)
                                <option value="{{ $status->name }}" {{ request('status') == $status->name ? 'selected' : '' }}>
                                    {{ ucfirst($status->name) }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-sm btn-primary ml-2">Filter</button>
                    </form>
                </div>
                @endif --}}
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
                    <table class="table text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Member</th>
                                <th>Incident</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Payment Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($contributions as $contribution)
                                <tr>
                                    <td>{{ $contribution->id }}</td>
                                    <td>
                                        <div>
                                            <strong>{{ $contribution->user->name ?? 'N/A' }}</strong>
                                            @if($contribution->getUserOrganization())
                                                <br><small class="text-muted">{{ $contribution->getUserOrganization()->name }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $contribution->incident->deceased_name ?? 'N/A' }}</strong>
                                            <br><small class="text-muted">{{ $contribution->incident->date_of_death ? $contribution->incident->date_of_death->format('M d, Y') : '' }}</small>
                                        </div>
                                    </td>
                                    <td>${{ number_format($contribution->amount, 2) }}</td>
                                    <td>
                                        <span class="badge badge-{{ $contribution->isPaid() ? 'success' : ($contribution->isPending() ? 'warning' : 'danger') }}">
                                            {{ ucfirst($contribution->status->name ?? 'Unknown') }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($contribution->transaction && $contribution->transaction->created_at)
                                            {{ $contribution->transaction->created_at->format('M d, Y') }}
                                        @else
                                            <span class="text-muted">Not paid</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            @if(hasPermissionOrRole('read-contribution'))
                                            <a href="{{ route('admin.contributions.show', $contribution) }}"
                                               class="btn btn-sm btn-info" title="View">
                                                <i class="fe fe-eye"></i>
                                            </a>
                                            @endif

                                            @if(!$contribution->isPaid() && hasPermissionOrRole('pay-contribution'))
                                                <a href="{{ route('admin.contributions.pay', $contribution) }}"
                                                   class="btn btn-sm btn-primary" title="Pay">
                                                    <i class="fe fe-credit-card"></i>
                                                </a>
                                            @endif

                                            @if(hasPermissionOrRole('update-contribution') && !$contribution->isPaid())
                                                <button type="button" class="btn btn-sm btn-success"
                                                        data-toggle="modal"
                                                        data-target="#markAsPaidModal{{ $contribution->id }}"
                                                        title="Mark as Paid">
                                                    <i class="fe fe-check"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No contributions found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $contributions->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mark as Paid Modal -->
@foreach($contributions as $contribution)
    @if(!$contribution->isPaid())
    <div class="modal fade" id="markAsPaidModal{{ $contribution->id }}" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('admin.contributions.mark-as-paid', $contribution) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Mark as Paid</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Member: {{ $contribution->user->name }}</label>
                        </div>
                        <div class="form-group">
                            <label>Amount: ${{ number_format($contribution->amount, 2) }}</label>
                        </div>
                        <div class="form-group">
                            <label for="payment_method_id">Payment Method *</label>
                            <select name="payment_method_id" id="payment_method_id" class="form-control" required>
                                <option value="">Select Payment Method</option>
                                @foreach(\App\Models\PaymentMethod::where('is_active', true)->get() as $method)
                                    <option value="{{ $method->id }}">{{ $method->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="notes">Notes</label>
                            <textarea name="notes" id="notes" class="form-control" rows="3"
                                      placeholder="Optional notes about the payment"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Mark as Paid</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
@endforeach
@endsection
