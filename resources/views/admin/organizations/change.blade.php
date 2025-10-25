@extends('admin.layouts.app')

@section('title', 'Change Organization Leader')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        @php
            $breadcrumbs = [
                ['label' => 'Dashboard', 'url' => '/dashboard'],
                ['label' => 'Organizations', 'url' => route('admin.organizations.index')],
                ['label' => 'Change Organization Leader', 'url' => '']
            ];
        @endphp
        @include('admin.layouts.page-title', ['breadcrumbs' => $breadcrumbs])
        
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Change Organization Leader</h4>
                        <div class="card-tools">
                            <a href="{{ route('admin.organizations.index') }}" class="btn btn-light btn-sm">
                                <span class="fe fe-arrow-left"></span> Back to List
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($organizations->count() > 0)
                            <form action="{{ route('admin.organizations.change') }}" method="POST" id="changeLeaderForm">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="organization_id" class="form-label">Select Organization</label>
                                        <select class="form-control @error('organization_id') is-invalid @enderror" id="organization_id" name="organization_id" required>
                                            <option value="">Select Organization</option>
                                            @foreach($organizations as $organization)
                                                <option value="{{ $organization->id }}" {{ old('organization_id') == $organization->id ? 'selected' : '' }}>
                                                    {{ $organization->name }} ({{ ucfirst($organization->type) }}) - Current Leader: {{ $organization->leader->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('organization_id')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="new_leader_id" class="form-label">Select New Leader</label>
                                        <select class="form-control @error('new_leader_id') is-invalid @enderror" id="new_leader_id" name="new_leader_id" required disabled>
                                            <option value="">First select an organization</option>
                                        </select>
                                        @error('new_leader_id')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <!-- Organization Members Display -->
                                <div class="row" id="membersSection" style="display: none;">
                                    <div class="col-12">
                                        <h5 class="mb-3">Organization Members</h5>
                                        <div class="table-responsive">
                                            <table class="table table-striped" id="membersTable">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Phone</th>
                                                        <th>Member Since</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- Members will be loaded via AJAX -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.organizations.index') }}" class="btn btn-light">Cancel</a>
                                    <button type="submit" class="btn btn-primary" id="submitBtn" disabled>
                                        <span class="fe fe-user-check"></span> Change Leader
                                    </button>
                                </div>
                            </form>
                        @else
                            <div class="alert alert-info">
                                <h5>No Organizations Available</h5>
                                <p>You don't have access to any organizations or there are no organizations in the system.</p>
                                <a href="{{ route('admin.organizations.create') }}" class="btn btn-primary">Create Organization</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    const organizationSelect = $('#organization_id');
    const newLeaderSelect = $('#new_leader_id');
    const membersSection = $('#membersSection');
    const membersTable = $('#membersTable tbody');
    const submitBtn = $('#submitBtn');

    // When organization is selected, load members and enable new leader selection
    organizationSelect.on('change', function() {
        const organizationId = $(this).val();
        
        if (organizationId) {
            // Load organization members
            loadOrganizationMembers(organizationId);
            
            // Enable new leader selection
            newLeaderSelect.prop('disabled', false);
            newLeaderSelect.html('<option value="">Loading members...</option>');
            
            // Load members for leader selection
            loadMembersForLeaderSelection(organizationId);
        } else {
            // Reset form
            newLeaderSelect.prop('disabled', true).html('<option value="">First select an organization</option>');
            membersSection.hide();
            submitBtn.prop('disabled', true);
        }
    });

    // When new leader is selected, enable submit button
    newLeaderSelect.on('change', function() {
        submitBtn.prop('disabled', !$(this).val());
    });

    function loadOrganizationMembers(organizationId) {
        $.ajax({
            url: '{{ route("admin.organizations.members") }}',
            method: 'GET',
            data: { organization_id: organizationId },
            success: function(response) {
                membersTable.empty();
                
                if (response.members && response.members.length > 0) {
                    response.members.forEach(function(member) {
                        const row = `
                            <tr>
                                <td>${member.name}</td>
                                <td>${member.email}</td>
                                <td>${member.phone || 'N/A'}</td>
                                <td>${member.membership_start_date}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary select-leader" data-member-id="${member.id}">
                                        Select as Leader
                                    </button>
                                </td>
                            </tr>
                        `;
                        membersTable.append(row);
                    });
                    
                    membersSection.show();
                    
                    // Add click handler for select leader buttons
                    $('.select-leader').on('click', function() {
                        const memberId = $(this).data('member-id');
                        newLeaderSelect.val(memberId).trigger('change');
                        $('html, body').animate({
                            scrollTop: newLeaderSelect.offset().top - 100
                        }, 500);
                    });
                } else {
                    membersTable.append('<tr><td colspan="5" class="text-center">No members found</td></tr>');
                    membersSection.show();
                }
            },
            error: function(xhr) {
                console.error('Error loading members:', xhr.responseText);
                membersTable.html('<tr><td colspan="5" class="text-center text-danger">Error loading members</td></tr>');
                membersSection.show();
            }
        });
    }

    function loadMembersForLeaderSelection(organizationId) {
        $.ajax({
            url: '{{ route("admin.organizations.members") }}',
            method: 'GET',
            data: { organization_id: organizationId },
            success: function(response) {
                newLeaderSelect.html('<option value="">Select New Leader</option>');
                
                if (response.members && response.members.length > 0) {
                    response.members.forEach(function(member) {
                        newLeaderSelect.append(`<option value="${member.id}">${member.name} (${member.email})</option>`);
                    });
                } else {
                    newLeaderSelect.html('<option value="">No members available</option>');
                }
            },
            error: function(xhr) {
                console.error('Error loading members for selection:', xhr.responseText);
                newLeaderSelect.html('<option value="">Error loading members</option>');
            }
        });
    }
});
</script>
@endpush
@endsection
