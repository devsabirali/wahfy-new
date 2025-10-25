@extends('admin.layouts.app')
@section('content')
    <!-- PAGE-HEADER -->
    <div class="page-header">
        <h1 class="page-title">
            Wahfy {{ $roleDisplay }} Dashboard
        </h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->

    <!-- ROW-1: Main Cards -->
    <div class="row">
        @php
            $user = auth()->user();
            $organizationName = null;

            // Get organization name if user has any organization
            if ($user && $user->hasRole(['indivisual-member', 'family-leader', 'group-leader'])) {
                $organization = $user->organizations()->first(); // adjust relationship if needed

                if ($organization) {
                    $organizationName = $organization->name;
                } elseif ($user->family_name) {
                    $organizationName = $user->family_name;
                } elseif ($user->group_name) {
                    $organizationName = $user->group_name;
                }
            }
        @endphp

        @if($organizationName)
        <div class="col-lg-4 col-md-6">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="mt-2">
                            <h6>Organization Name</h6>
                            <h2 class="mb-0 number-font">{{ $organizationName }}</h2>
                        </div>
                        <div class="ms-auto">
                            <i class="fe fe-users fs-30 text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if($isAdmin)
        <div class="col-lg-4 col-md-6">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="mt-2">
                            <h6>Total Users</h6>
                            <h2 class="mb-0 number-font">{{ $totalUsers }}</h2>
                        </div>
                        <div class="ms-auto">
                            <i class="fe fe-users fs-30 text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <div class="col-lg-4 col-md-6">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="mt-2">
                            <h6>No. Contributions</h6>
                            <h2 class="mb-0 number-font">{{ $totalDonations }}</h2>
                        </div>
                        <div class="ms-auto">
                            <i class="fe fe-heart fs-30 text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="mt-2">
                            <h6>Total Events</h6>
                            <h2 class="mb-0 number-font">{{ $totalIncidents }}</h2>
                        </div>
                        <div class="ms-auto">
                            <i class="fe fe-alert-triangle fs-30 text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if($isAdmin)
        <div class="col-lg-4 col-md-6">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="mt-2">
                            <h6>Total Organizations</h6>
                            <h2 class="mb-0 number-font">{{ $totalOrganizations }}</h2>
                        </div>
                        <div class="ms-auto">
                            <i class="fe fe-briefcase fs-30 text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <div class="col-lg-4 col-md-6">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="mt-2">
                            <h6>Total Members</h6>
                            <h2 class="mb-0 number-font">{{ $totalMembers }}</h2>
                        </div>
                        <div class="ms-auto">
                            <i class="fe fe-user-plus fs-30 text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="mt-2">
                            <h6>Total Contributions</h6>
                            <h2 class="mb-0 number-font">{{ $donationAmount }}</h2>
                        </div>
                        <div class="ms-auto">
                            <i class="fe fe-dollar-sign fs-30 text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ROW-1 END -->

    <!-- Donations & Incidents Chart (if present) -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Donations & Events This Year</h3>
                </div>
                <div class="card-body">
                    <canvas id="donationsIncidentsChart" style="width:100%"></canvas>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const donationsData = @json(array_values($donationsPerYear));
        const incidentsData = @json(array_values($incidentsPerYear));
        const years = @json($years);
        const ctx = document.getElementById('donationsIncidentsChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: years,
                datasets: [
                    {
                        label: 'Donations',
                        data: donationsData,
                        borderColor: '#007bff',
                        fill: false
                    },
                    {
                        label: 'Events',
                        data: incidentsData,
                        borderColor: '#dc3545',
                        fill: false
                    }
                ]
            }
        });

        var el = document.querySelector('.your-scrollbar-element');
        if (el) {
            new PerfectScrollbar(el);
        }
    </script>

    @if($isAdmin)
    <!-- Recent Contact Submissions -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Recent Contact Submissions</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentContacts as $contact)
                    <tr>
                        <td>{{ $contact->name }}</td>
                        <td>{{ $contact->email }}</td>
                        <td>{{ Str::limit($contact->message, 50) }}</td>
                        <td>{{ $contact->created_at->format('d M Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!-- Recent Donations -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Recent Donations</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Donor</th>
                        <th>Amount</th>
                        <th>Type</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentDonations as $donation)
                    <tr>
                        <td>{{ $donation->first_name }} {{ $donation->last_name }}</td>
                        <td>{{ $donation->amount }}</td>
                        <td>{{ ucfirst($donation->donation_type) }}</td>
                        <td>{{ $donation->created_at->format('d M Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
