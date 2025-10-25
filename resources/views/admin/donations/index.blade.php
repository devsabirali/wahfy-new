@extends('admin.layouts.app')

@section('content')
            <!-- PAGE-HEADER -->
            <div class="page-header">
                <div>
                    <h1 class="page-title">Donations</h1>
                </div>
                <div class="ms-auto pageheader-btn">
                    @if(hasPermissionOrRole('donation-create'))
                    <a href="{{ route('admin.donations.create') }}" class="btn btn-primary btn-icon text-white me-2">
                        <span><i class="fe fe-plus"></i></span> Add New Donation
                    </a>
                    @endif
                </div>
            </div>
            <!-- PAGE-HEADER END -->

            <!-- Row -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">All Donations</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered text-nowrap border-bottom" id="basic-datatable">
                                    <thead>
                                        <tr>
                                            <th class="wd-15p border-bottom-0">ID</th>
                                            <th class="wd-15p border-bottom-0">Donor</th>
                                            <th class="wd-15p border-bottom-0">Amount</th>
                                            <th class="wd-15p border-bottom-0">Type</th>
                                            {{-- <th class="wd-15p border-bottom-0">Status</th> --}}
                                            <th class="wd-15p border-bottom-0">Date</th>
                                            <th class="wd-15p border-bottom-0">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($donations as $donation)
                                        <tr>
                                            <td>{{ $donation->id }}</td>
                                            <td>
                                                {{ $donation->first_name }} {{ $donation->last_name }}<br>
                                                <small class="text-muted">{{ $donation->email }}</small>
                                            </td>
                                            <td>${{ number_format($donation->amount, 2) }}</td>
                                            <td>{{ ucfirst($donation->donation_type) }}</td>
                                            {{-- <td>
                                                <span class="badge {{ $member->status->name == 'Active' ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $donation->status->name }}
                                                </span>
                                            </td> --}}
                                            <td>{{ $donation->created_at->format('M d, Y H:i') }}</td>
                                            <td>
                                                <a href="{{ route('admin.donations.show', $donation) }}" class="btn btn-sm text-primary">
                                                    <i class="fe fe-eye"></i>
                                                </a>
                                                @if(hasPermissionOrRole('donation-edit'))
                                                <a href="{{ route('admin.donations.edit', $donation) }}" class="btn btn-sm text-info">
                                                    <i class="fe fe-edit"></i>
                                                </a>
                                                @endif
                                                @if(hasPermissionOrRole('donation-delete'))
                                                <form action="{{ route('admin.donations.destroy', $donation) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm text-danger" onclick="return confirm('Are you sure you want to delete this donation?')">
                                                        <i class="fe fe-trash"></i>
                                                    </button>
                                                </form>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4">
                                {{ $donations->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#basic-datatable').DataTable({
            "pageLength": 10,
            "ordering": true,
            "responsive": true,
            "language": {
                "search": "Search:",
                "lengthMenu": "Show _MENU_ entries per page",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries"
            }
        });
    });
</script>
@endpush
