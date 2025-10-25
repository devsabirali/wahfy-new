@extends('admin.layouts.app')

@section('content')
            <!-- PAGE-HEADER -->
            <div class="page-header">
                <div>
                    <h1 class="page-title">Add New Donation</h1>
                </div>
                <div class="ms-auto pageheader-btn">
                    @if(hasPermissionOrRole('donation-read'))
                    <a href="{{ route('admin.donations.index') }}" class="btn btn-primary btn-icon text-white me-2">
                        <span><i class="fe fe-arrow-left"></i></span> Back to Donations
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
                            <h3 class="card-title">Donation Details</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.donations.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="first_name">First Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                                id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                                            @error('first_name')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="last_name">Last Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                                id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                                            @error('last_name')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="amount">Amount <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror"
                                        id="amount" name="amount" value="{{ old('amount') }}" required>
                                    @error('amount')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="donation_type">Donation Type <span class="text-danger">*</span></label>
                                    <select class="form-control @error('donation_type') is-invalid @enderror"
                                        id="donation_type" name="donation_type" required>
                                        <option value="">Select Type</option>
                                        <option value="incident" {{ old('donation_type') == 'incident' ? 'selected' : '' }}>Event</option>
                                        <option value="general" {{ old('donation_type') == 'general' ? 'selected' : '' }}>General</option>
                                    </select>
                                    @error('donation_type')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group" id="incident_id_group" style="display: none;">
                                    <label for="incident_id">Event <span class="text-danger">*</span></label>
                                    <select class="form-control @error('incident_id') is-invalid @enderror"
                                        id="incident_id" name="incident_id">
                                        <option value="">Select Event</option>
                                        @foreach($incidents as $incident)
                                            <option value="{{ $incident->id }}" {{ old('incident_id') == $incident->id ? 'selected' : '' }}>
                                                {{ $incident->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('incident_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="payment_method">Payment Method <span class="text-danger">*</span></label>
                                    <select class="form-control @error('payment_method') is-invalid @enderror"
                                        id="payment_method" name="payment_method" required>
                                        <option value="">Select Method</option>
                                        <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>Card</option>
                                        <option value="offline" {{ old('payment_method') == 'offline' ? 'selected' : '' }}>Offline</option>
                                    </select>
                                    @error('payment_method')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="status">Status <span class="text-danger">*</span></label>
                                    <select class="form-control @error('status') is-invalid @enderror"
                                        id="status" name="status" required>
                                        <option value="">Select Status</option>
                                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                    @error('status')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="notes">Notes</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror"
                                        id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Create Donation</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Row -->
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Show/hide incident selection based on donation type
        $('#donation_type').change(function() {
            if ($(this).val() === 'incident') {
                $('#incident_id_group').show();
                $('#incident_id').prop('required', true);
            } else {
                $('#incident_id_group').hide();
                $('#incident_id').prop('required', false);
            }
        });

        // Trigger change event on page load
        $('#donation_type').trigger('change');
    });
</script>
@endpush
