@extends('admin.layouts.app')

@section('title', 'Events')

@section('content')
<div class="page-header">
    <div class="page-leftheader">
        <h4 class="page-title mb-0">Events</h4>
    </div>
    <div class="page-rightheader ml-auto d-lg-flex d-none">
        @if(hasPermissionOrRole('create-incident'))
        <a href="{{ route('admin.incidents.create') }}" class="btn btn-primary">
            <i class="fe fe-plus mr-2"></i> Add New Event
        </a>
        @endif
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Events List</h3>
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
                                <th>Thumbnail</th>
                                <th>User</th>
                                <th>Type</th>
                                <th>Deceased Name</th>
                                <th>Date of Death</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Images</th>
                                <th>Verified By</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($incidents as $incident)
                                <tr>
                                    <td>{{ $incident->id }}</td>
                                    <td>
                                        @if($incident->thumbnail_path)
                                            <img src="{{ Storage::url($incident->thumbnail_path) }}"
                                                 alt="Event Thumbnail"
                                                 class="img-thumbnail"
                                                 style="max-width: 100px;">
                                        @else
                                            No Thumbnail
                                        @endif
                                    </td>
                                    <td>{{ $incident->user->name ?? 'N/A' }}</td>
                                    <td>{{ $incident->type ?? 'N/A' }}</td>
                                    <td>{{ $incident->deceased_name }}</td>
                                    <td>{{ $incident->date_of_death }}</td>
                                    <td>{{ number_format($incident->amount, 2) }}</td>
                                    <td>
                                        <span class="badge text-{{ $incident->status->name === 'Verified' ? 'success' : ($incident->status->name === 'Pending' ? 'warning' : 'danger') }}">
                                            {{ $incident->status->name }}
                                        </span>
                                    </td>
                                    <td>
                                    @php
                                        $images = $incident->images;
                                        $totalImages = $images->count();
                                        $maxDisplay = 3;
                                    @endphp

                                    @if($totalImages)
                                        <div class="d-flex gap-1">
                                            @foreach($images->take($maxDisplay) as $index => $image)
                                                <div class="position-relative">
                                                    <img src="{{ Storage::url($image->image_path) }}"
                                                        class="img-thumbnail"
                                                        style="width:60px; height:60px; object-fit:cover;">
                                                    @if($index === $maxDisplay - 1 && $totalImages > $maxDisplay)
                                                        <a href="{{ route('admin.incident-images.index', ['incident_id' => $incident->id]) }}"
                                                        style="position:absolute; top:0; left:0; width:60px; height:60px;
                                                                background:rgba(0,0,0,0.6); color:#fff;
                                                                display:flex; align-items:center; justify-content:center;
                                                                font-weight:bold; font-size:14px; text-decoration:none;">
                                                            +{{ $totalImages - $maxDisplay }}
                                                        </a>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                        <a href="{{ route('admin.incident-images.index', ['incident_id' => $incident->id]) }}" class="d-block mt-1">Manage Images</a>
                                    @else
                                        <span class="text-muted">No images</span>
                                    @endif
                                </td>

                                    <td>{{ $incident->verifiedBy->name ?? 'Not Verified' }}</td>
                                    {{-- <td>{{ $incident->createdBy->name ?? 'N/A' }}</td>
                                    <td>{{ $incident->created_at->format('Y-m-d H:i:s') }}</td> --}}
                                    <td>
                                        <div class="btn-group">
                                            @if(hasPermissionOrRole('read-incident'))
                                            <a href="{{ route('admin.incidents.show', $incident) }}"
                                               class="btn btn-sm text-info"
                                               title="View">
                                                <i class="fe fe-eye"></i>
                                            </a>
                                            @endif
                                            @if(hasPermissionOrRole('update-incident'))
                                            <a href="{{ route('admin.incidents.edit', $incident) }}"
                                               class="btn btn-sm text-primary"
                                               title="Edit">
                                                <i class="fe fe-edit"></i>
                                            </a>
                                            @endif
                                            @if($isAdmin && !$incident->verified_by && hasPermissionOrRole('update-incident'))
                                                <form action="{{ route('admin.incidents.verify', $incident) }}"
                                                      method="POST"
                                                      class="d-inline">
                                                    @csrf
                                                    <button type="submit"
                                                            class="btn btn-sm text-success"
                                                            title="Verify"
                                                            onclick="return confirm('Are you sure you want to verify this incident?')">
                                                        <i class="fe fe-check"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            @if(hasPermissionOrRole('delete-incident'))
                                            <form action="{{ route('admin.incidents.destroy', $incident) }}"
                                                  method="POST"
                                                  class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-sm text-danger"
                                                        title="Delete"
                                                        onclick="return confirm('Are you sure you want to delete this incident?')">
                                                    <i class="fe fe-trash"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center">No incidents found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $incidents->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
