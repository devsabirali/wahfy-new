@extends('admin.layouts.app')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        @php
            $breadcrumbs = [
                ['label' => 'Dashboard', 'url' => '/dashboard'],
                ['label' => 'Roles', 'url' => '/roles'],
                ['label' => 'Edit Role', 'url' => '']
            ];
        @endphp

        @include('admin.layouts.page-title', ['breadcrumbs' => $breadcrumbs])

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Edit Role: {{ $role->name }}</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.roles.update', $role->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label"><strong>Role Name</strong></label>
                                <input type="text" name="name" class="form-control"
                                       value="{{ old('name', $role->name) }}" required>
                            </div>

                            <div class="mb-4">
                                <h5><strong>Permissions</strong></h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Model</th>
                                                <th class="text-center">Create</th>
                                                <th class="text-center">Read</th>
                                                <th class="text-center">Update</th>
                                                <th class="text-center">Delete</th>
                                                <th class="text-center">pay</th>
                                                <th class="text-center">Select All</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $grouped = [];
                                                foreach ($permissions as $perm) {
                                                    $parts = explode('-', $perm->name);
                                                    $action = $parts[0] ?? '';
                                                    $model = $parts[1] ?? '';
                                                    if ($model && $action) {
                                                        $grouped[$model][$action] = $perm;
                                                    }
                                                }
                                            @endphp

                                            @foreach ($grouped as $model => $actions)
                                            <tr>
                                                <td class="text-capitalize">{{ $model }}</td>
                                                @foreach (['create', 'read', 'update', 'delete','pay'] as $action)
                                                <td class="text-center">
                                                    @if (isset($actions[$action]))
                                                        <input type="checkbox"
                                                               class="form-check-input permission-checkbox"
                                                               name="permissions[{{ $actions[$action]->id }}]"
                                                               value="{{ $actions[$action]->id }}"
                                                               data-model="{{ $model }}"
                                                               {{ in_array($actions[$action]->id, $rolePermissions) ? 'checked' : '' }}>
                                                    @endif
                                                </td>
                                                @endforeach
                                                <td class="text-center">
                                                    <input type="checkbox"
                                                           class="form-check-input check-all"
                                                           data-model="{{ $model }}"
                                                           id="check-all-{{ $model }}"
                                                           {{ count($actions) === count(array_filter($actions, fn($action) => in_array($action->id, $rolePermissions))) ? 'checked' : '' }}>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.roles.index') }}" class="btn btn-light">Cancel</a>
                                <button type="submit" class="btn btn-primary">
                                    Update Role
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    // Function to update check-all checkbox based on individual permissions
    function syncCheckAll(model) {
        const checkboxes = $(`.permission-checkbox[data-model="${model}"]`);
        const checked = checkboxes.filter(':checked').length;
        $(`#check-all-${model}`).prop('checked', checkboxes.length > 0 && checkboxes.length === checked);
    }

    // Initialize check-all checkboxes on page load
    $('.check-all').each(function() {
        const model = $(this).data('model');
        syncCheckAll(model);
    });

    // Handle check-all click
    $('.check-all').on('change', function() {
        const model = $(this).data('model');
        const isChecked = $(this).is(':checked');
        $(`.permission-checkbox[data-model="${model}"]`).prop('checked', isChecked);
    });

    // Handle individual checkbox change
    $('.permission-checkbox').on('change', function() {
        const model = $(this).data('model');
        syncCheckAll(model);
    });
});
</script>
@endpush
