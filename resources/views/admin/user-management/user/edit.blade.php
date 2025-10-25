@extends('admin.layouts.app')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        @php
            $breadcrumbs = [
                ['label' => 'Dashboard', 'url' => '/dashboard'],
                ['label' => 'Users', 'url' => route('admin.users.index')],
                ['label' => 'Edit User', 'url' => '']
            ];
        @endphp

        @include('admin.layouts.page-title', ['breadcrumbs' => $breadcrumbs])

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Edit User: {{ $user->getFullName() }}</h4>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#permissionsModal">
                                <i class="mdi mdi-shield-check"></i> Manage Permissions
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.users.update', $user->id) }}" id="userForm" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Add a hidden input for permissions -->
                            <input type="hidden" name="permissions" id="permissionsInput" value="{{ json_encode($userPermissions) }}">

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="roles" class="form-label">Roles</label>
                                    <select name="roles[]" class="form-select select2" multiple>
                                        @foreach($roles as $id => $name)
                                            <option value="{{ $id }}" {{ in_array($id, $userRoles) ? 'selected' : '' }}>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('roles')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                           id="first_name" name="first_name" value="{{ old('first_name', $user->first_name) }}" required>
                                    @error('first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="middle_name" class="form-label">Middle Name</label>
                                    <input type="text" class="form-control @error('middle_name') is-invalid @enderror"
                                           id="middle_name" name="middle_name" value="{{ old('middle_name', $user->middle_name) }}">
                                    @error('middle_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                           id="last_name" name="last_name" value="{{ old('last_name', $user->last_name) }}" required>
                                    @error('last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                           id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Phone <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                           id="phone" name="phone" value="{{ old('phone', $user->phone) }}" required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="id_number" class="form-label">ID Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('id_number') is-invalid @enderror"
                                           id="id_number" name="id_number" value="{{ old('id_number', $user->id_number) }}" required>
                                    @error('id_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="payment_status" class="form-label">Payment Status</label>
                                    <select class="form-select @error('payment_status') is-invalid @enderror"
                                            id="payment_status" name="payment_status">
                                        <option value="pending" {{ old('payment_status', $user->payment_status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="paid" {{ old('payment_status', $user->payment_status) == 'paid' ? 'selected' : '' }}>Paid</option>
                                        <option value="overdue" {{ old('payment_status', $user->payment_status) == 'overdue' ? 'selected' : '' }}>Overdue</option>
                                    </select>
                                    @error('payment_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3" id="organizationDropdown" style="display:none;">
                                    <label for="organization_id" class="form-label">Organization</label>
                                    <select class="form-select select2-org" id="organization_id" name="organization_id">
                                        <option value="">Select Organization</option>
                                        @foreach($organizations as $org)
                                            <option value="{{ $org->id }}" {{ old('organization_id', $user->organization_id) == $org->id ? 'selected' : '' }}>{{ $org->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3 leader-field">
                                    <label for="group_leader" class="form-label">Group Leader</label>
                                    <select class="form-select @error('group_leader') is-invalid @enderror" id="group_leader" name="group_leader">
                                        <option value="">Select</option>
                                        <option value="1" {{ old('group_leader', $user->group_leader) == '1' ? 'selected' : '' }}>Yes</option>
                                        <option value="0" {{ old('group_leader', $user->group_leader) == '0' ? 'selected' : '' }}>No</option>
                                    </select>
                                    @error('group_leader')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3 leader-field group-name-field">
                                    <label for="group_name" class="form-label">Group Name</label>
                                    <input type="text" class="form-control @error('group_name') is-invalid @enderror" id="group_name" name="group_name" value="{{ old('group_name', $user->group_name) }}">
                                    @error('group_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3 leader-field">
                                    <label for="family_leader" class="form-label">Family Leader</label>
                                    <select class="form-select @error('family_leader') is-invalid @enderror" id="family_leader" name="family_leader">
                                        <option value="">Select</option>
                                        <option value="1" {{ old('family_leader', $user->family_leader) == '1' ? 'selected' : '' }}>Yes</option>
                                        <option value="0" {{ old('family_leader', $user->family_leader) == '0' ? 'selected' : '' }}>No</option>
                                    </select>
                                    @error('family_leader')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3 leader-field family-name-field">
                                    <label for="family_name" class="form-label">Family Name</label>
                                    <input type="text" class="form-control @error('family_name') is-invalid @enderror" id="family_name" name="family_name" value="{{ old('family_name', $user->family_name) }}">
                                    @error('family_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                           id="password" name="password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="confirm-password" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control @error('confirm-password') is-invalid @enderror"
                                           id="confirm-password" name="confirm-password">
                                    @error('confirm-password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.users.index') }}" class="btn btn-light">Cancel</a>
                                @if(hasPermissionOrRole('update-users'))
                                    <button type="submit" class="btn btn-primary">Update User</button>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Permissions Modal -->
<div class="modal fade" id="permissionsModal" tabindex="-1" aria-labelledby="permissionsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="permissionsModalLabel">Manage Permissions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Module</th>
                                <th>Create</th>
                                <th>Read</th>
                                <th>Update</th>
                                <th>Delete</th>
                                <th>All</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($permissions as $module => $modulePermissions)
                                <tr>
                                    <td>{{ ucfirst($module) }}</td>
                                    @foreach(['create', 'read', 'update', 'delete'] as $action)
                                        <td>
                                            <div class="form-check">
                                                @if(isset($modulePermissions[$action]))
                                                    <input class="form-check-input permission-checkbox" type="checkbox"
                                                           name="permissions[]"
                                                           value="{{ $modulePermissions[$action] }}"
                                                           id="perm_{{ $module }}_{{ $action }}"
                                                           data-module="{{ $module }}"
                                                           data-action="{{ $action }}"
                                                           {{ in_array($modulePermissions[$action], $userPermissions) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="perm_{{ $module }}_{{ $action }}">
                                                        {{ ucfirst($action) }}
                                                    </label>
                                                @else
                                                    <input class="form-check-input" type="checkbox" disabled>
                                                    <label class="form-check-label text-muted">
                                                        {{ ucfirst($action) }}
                                                    </label>
                                                @endif
                                            </div>
                                        </td>
                                    @endforeach
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input check-all" type="checkbox"
                                                   data-module="{{ $module }}"
                                                   id="check_all_{{ $module }}"
                                                   {{ $modulePermissionsChecked[$module] ? 'checked' : '' }}>
                                            <label class="form-check-label" for="check_all_{{ $module }}">
                                                All
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="savePermissions">Save Permissions</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    initializeSelect2();
    initializePermissionHandlers();
    // Initialize Select2 for organization dropdown (single select with search)
    $('.select2-org').select2({
        placeholder: "Select Organization",
        allowClear: true,
        width: '100%'
    });
    handleRoleBasedFields();
    $('.select2').on('change', handleRoleBasedFields);
});

function initializeSelect2() {
    $('.select2').select2({
        placeholder: "Select roles",
        allowClear: true
    });

    // Handle role changes
    $('.select2').on('change', handleRoleChange);
}

function handleRoleChange() {
    const selectedRoles = $(this).val();

    if (selectedRoles && selectedRoles.length > 0) {
        $.ajax({
            url: `/admin/roles/permissions/${selectedRoles.join(',')}`,
            method: 'GET',
            success: function(permissions) {
                resetPermissions();
                checkPermissions(permissions);
                updateCheckAll();
            },
            error: function(xhr, status, error) {
                console.error('Error fetching permissions:', error);
            }
        });
    } else {
        resetPermissions();
    }
}

function resetPermissions() {
    $('.permission-checkbox, .check-all').prop('checked', false);
}

function checkPermissions(permissions) {
    permissions.forEach(permission => {
        $(`input[value="${permission}"]`).prop('checked', true);
    });
}

function initializePermissionHandlers() {
    // Handle check-all checkboxes
    $('.check-all').on('change', function() {
        const module = $(this).data('module');
        const isChecked = $(this).prop('checked');

        // Find all permission checkboxes for this module
        $(`.permission-checkbox[data-module="${module}"]`).each(function() {
            if (!$(this).prop('disabled')) {
                $(this).prop('checked', isChecked);
            }
        });
        updatePermissionsInput();
    });

    // Handle individual permission checkboxes
    $('.permission-checkbox').on('change', function() {
        const module = $(this).data('module');
        updateModuleCheckAll(module);
        updatePermissionsInput();
    });

    // Handle save permissions
    $('#savePermissions').on('click', function() {
        updatePermissionsInput();
        $('#permissionsModal').modal('hide');
    });

    // Handle modal close
    $('#permissionsModal').on('hidden.bs.modal', function() {
        updatePermissionsInput();
    });
}

function updatePermissionsInput() {
    const selectedPermissions = [];
    $('.permission-checkbox:checked').each(function() {
        const permissionId = parseInt($(this).val());
        if (!isNaN(permissionId)) {
            selectedPermissions.push(permissionId);
        }
    });
    $('#permissionsInput').val(JSON.stringify(selectedPermissions));
}

function updateModuleCheckAll(module) {
    const moduleCheckboxes = $(`.permission-checkbox[data-module="${module}"]:not(:disabled)`);
    const allChecked = moduleCheckboxes.length > 0 &&
                      moduleCheckboxes.length === moduleCheckboxes.filter(':checked').length;

    $(`.check-all[data-module="${module}"]`).prop('checked', allChecked);
}

function updateCheckAll() {
    $('.check-all').each(function() {
        const module = $(this).data('module');
        updateModuleCheckAll(module);
    });
}

function handleRoleBasedFields() {
    const selectedRoles = $('.select2').val() || [];
    let isMember = false;
    // Find the role name for 'member' (case-insensitive)
    $('.select2 option:selected').each(function() {
        if ($(this).text().trim().toLowerCase() === 'member') {
            isMember = true;
        }
    });
    if (isMember) {
        $('#organizationDropdown').show();
        $('.leader-field').hide();
        $('.group-name-field').hide();
        $('.family-name-field').hide();
    } else {
        $('#organizationDropdown').hide();
        $('.leader-field').show();
        $('.group-name-field').show();
        $('.family-name-field').show();
    }
}
</script>
@endpush

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
