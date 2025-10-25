@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Pending Donations</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table ">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Donor Name</th>
                                    <th>Email</th>
                                    <th>Amount</th>
                                    <th>Type</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendingDonations as $donation)
                                <tr>
                                    <td>{{ $donation->id }}</td>
                                    <td>{{ $donation->first_name }} {{ $donation->last_name }}</td>
                                    <td>{{ $donation->email }}</td>
                                    <td>${{ number_format($donation->amount, 2) }}</td>
                                    <td>{{ ucfirst($donation->donation_type) }}</td>
                                    <td>{{ $donation->created_at->format('M d, Y H:i') }}</td>
                                    <td>
                                        @if(hasPermissionOrRole('donation-approve'))
                                        <button class="btn btn-outline-success btn-sm approve-donation" data-id="{{ $donation->id }}">
                                            <i class="fas fa-check"></i> Approve
                                        </button>
                                        @endif
                                        @if(hasPermissionOrRole('donation-reject'))
                                        <button class="btn btn-outline-danger  btn-sm reject-donation" data-id="{{ $donation->id }}">
                                            <i class="fas fa-times"></i> Reject
                                        </button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $pendingDonations->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle approve button clicks
    document.querySelectorAll('.approve-donation').forEach(button => {
        button.addEventListener('click', async function() {
            if (!confirm('Are you sure you want to approve this donation?')) return;

            const id = this.dataset.id;
            try {
                const response = await fetch(`/admin/donations/${id}/approve`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();
                if (data.success) {
                    alert('Donation approved successfully');
                    location.reload();
                } else {
                    throw new Error(data.message);
                }
            } catch (error) {
                alert('Error: ' + error.message);
            }
        });
    });

    // Handle reject button clicks
    document.querySelectorAll('.reject-donation').forEach(button => {
        button.addEventListener('click', async function() {
            if (!confirm('Are you sure you want to reject this donation?')) return;

            const id = this.dataset.id;
            try {
                const response = await fetch(`/admin/donations/${id}/reject`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();
                if (data.success) {
                    alert('Donation rejected successfully');
                    location.reload();
                } else {
                    throw new Error(data.message);
                }
            } catch (error) {
                alert('Error: ' + error.message);
            }
        });
    });
});
</script>
@endpush
@endsection
