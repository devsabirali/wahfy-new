@extends('admin.layouts.app')

@section('title', 'View Contribution')

@section('content')
<div class="page-header">
    <div class="page-leftheader">
        <h4 class="page-title mb-0">View Contribution</h4>
    </div>
    <div class="page-rightheader ml-auto d-lg-flex d-none">
        @if(hasPermissionOrRole('read-contribution'))
        <a href="{{ route('admin.contributions.index') }}" class="btn btn-secondary">
            <i class="fe fe-arrow-left mr-2"></i> Back to List
        </a>
        @endif
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Contribution Details</h3>
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

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Member</label>
                            <p class="form-control-static">
                                <strong>{{ $contribution->user->name ?? 'N/A' }}</strong>
                                @if($contribution->getUserOrganization())
                                    <br><small class="text-muted">{{ $contribution->getUserOrganization()->name }}</small>
                                @endif
                            </p>
                        </div>

                        <div class="form-group">
                            <label>Incident</label>
                            <p class="form-control-static">
                                <strong>{{ $contribution->incident->deceased_name ?? 'N/A' }}</strong>
                                @if($contribution->incident->date_of_death)
                                    <br><small class="text-muted">Date of Death: {{ $contribution->incident->date_of_death->format('M d, Y') }}</small>
                                @endif
                            </p>
                        </div>

                        <div class="form-group">
                            <label>Amount</label>
                            <p class="form-control-static">
                                <strong class="text-primary">${{ number_format($contribution->amount, 2) }}</strong>
                            </p>
                        </div>

                        <div class="form-group">
                            <label>Admin Fee</label>
                            <p class="form-control-static">
                                ${{ number_format($contribution->admin_fee, 2) }}
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Status</label>
                            <p class="form-control-static">
                                <span class="badge badge-{{ $contribution->isPaid() ? 'success' : ($contribution->isPending() ? 'warning' : 'danger') }} badge-lg">
                                    {{ ucfirst($contribution->status->name ?? 'Unknown') }}
                                </span>
                            </p>
                        </div>

                        <div class="form-group">
                            <label>Payment Date</label>
                            <p class="form-control-static">
                                @if($contribution->transaction && $contribution->transaction->created_at)
                                    {{ $contribution->transaction->created_at->format('M d, Y H:i:s') }}
                                @else
                                    <span class="text-muted">Not paid yet</span>
                                @endif
                            </p>
                        </div>

                        @if($contribution->transaction)
                        <div class="form-group">
                            <label>Payment Method</label>
                            <p class="form-control-static">
                                {{ $contribution->transaction->paymentMethod->name ?? 'N/A' }}
                            </p>
                        </div>

                        @if($contribution->transaction->stripe_payment_intent_id)
                        <div class="form-group">
                            <label>Stripe Payment ID</label>
                            <p class="form-control-static">
                                <code>{{ $contribution->transaction->stripe_payment_intent_id }}</code>
                            </p>
                        </div>
                        @endif

                        @if($contribution->transaction->notes)
                        <div class="form-group">
                            <label>Notes</label>
                            <p class="form-control-static">
                                {{ $contribution->transaction->notes }}
                            </p>
                        </div>
                        @endif
                        @endif

                        <div class="form-group">
                            <label>Created</label>
                            <p class="form-control-static">
                                {{ $contribution->created_at->format('M d, Y H:i:s') }}
                            </p>
                        </div>

                        <div class="form-group">
                            <label>Last Updated</label>
                            <p class="form-control-static">
                                {{ $contribution->updated_at->format('M d, Y H:i:s') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    @if(!$contribution->isPaid())
                        <a href="{{ route('admin.contributions.pay', $contribution) }}" class="btn btn-primary">
                            <i class="fe fe-credit-card mr-2"></i> Pay Now
                        </a>
                    @endif

                    @if(auth()->user()->hasRole('admin') && !$contribution->isPaid())
                        <button type="button" class="btn btn-success"
                                data-toggle="modal"
                                data-target="#markAsPaidModal">
                            <i class="fe fe-check mr-2"></i> Mark as Paid
                        </button>
                    @endif

                    <a href="{{ route('admin.contributions.index') }}" class="btn btn-secondary">
                        <i class="fe fe-arrow-left mr-2"></i> Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mark as Paid Modal -->
@if(auth()->user()->hasRole('admin') && !$contribution->isPaid())
<div class="modal fade" id="markAsPaidModal" tabindex="-1" role="dialog">
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
@endsection
