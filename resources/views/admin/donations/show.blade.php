@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <div>
                        <h1 class="page-title">Donation Details</h1>
                    </div>
                    <div class="ms-auto pageheader-btn">
                        @if(hasPermissionOrRole('donation-read'))
                        <a href="{{ route('admin.donations.index') }}" class="btn btn-primary btn-icon text-white me-2">
                            <span><i class="fe fe-arrow-left"></i></span> Back to Donations
                        </a>
                        @endif
                        @if(hasPermissionOrRole('donation-edit'))
                        <a href="{{ route('admin.donations.edit', $donation) }}"
                            class="btn btn-info btn-icon text-white me-2">
                            <span><i class="fe fe-edit"></i></span> Edit Donation
                        </a>
                        @endif
                    </div>
                </div>
                <!-- PAGE-HEADER END -->

                <!-- Row -->
                <div class="row row-sm">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Donation Information</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Donor Name</label>
                                            <p class="form-control-static">{{ $donation->first_name }}
                                                {{ $donation->last_name }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Email</label>
                                            <p class="form-control-static">{{ $donation->email }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Amount</label>
                                            <p class="form-control-static">${{ number_format($donation->amount, 2) }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Donation Type</label>
                                            <p class="form-control-static">{{ ucfirst($donation->donation_type) }}</p>
                                        </div>
                                    </div>
                                </div>

                                @if($donation->donation_type === 'incident' && $donation->incident)
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">Event</label>
                                                <p class="form-control-static">
                                                    <a href="{{ route('admin.incidents.show', $donation->incident) }}">
                                                        {{ $donation->incident->title }}
                                                    </a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Payment Method</label>
                                            <p class="form-control-static">{{ ucfirst($donation->payment_method) }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Status</label>
                                            <p class="form-control-static">
                                                <span
                                                    class="badge bg-{{ $donation->status === 'approved' ? 'success' : ($donation->status === 'pending' ? 'warning' : 'danger') }}">
                                                    {{ ucfirst($donation->status) }}
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Created</label>
                                            <p class="form-control-static">{{ $donation->created_at->format('M d, Y H:i') }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Updated At</label>
                                            <p class="form-control-static">{{ $donation->updated_at->format('M d, Y H:i') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                @if($donation->notes)
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">Notes</label>
                                                <p class="form-control-static">{{ $donation->notes }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if($donation->status === 'pending')
                                    <div class="row mt-4">
                                        <div class="col-md-12">
                                            <form action="{{ route('admin.donations.approve', $donation) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-success me-2">
                                                    <i class="fe fe-check"></i> Approve Donation
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.donations.reject', $donation) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-danger"
                                                    onclick="return confirm('Are you sure you want to reject this donation?')">
                                                    <i class="fe fe-x"></i> Reject Donation
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
