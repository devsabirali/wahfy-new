@extends('admin.layouts.app')

@section('title', 'View Event')

@section('content')
<div class="page-header">
    <div class="page-leftheader">
        <h4 class="page-title mb-0">Event Details</h4>
    </div>
    <div class="page-rightheader ml-auto d-lg-flex d-none">
        <a href="{{ route('admin.incidents.index') }}" class="btn btn-light">
            <i class="fe fe-arrow-left mr-2"></i> Back to Events
        </a>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
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

                {{-- Probation Status Information --}}
                @if($probationStatus['status'] !== 'completed')
                    <div class="alert alert-{{ $probationStatus['status'] === 'not_started' ? 'warning' : 'info' }} mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong>Probation Status:</strong> {{ $probationStatus['message'] }}
                                @if($probationStatus['start_date'])
                                    <br><small class="text-muted">
                                        Started: {{ $probationStatus['start_date']->format('M d, Y') }} |
                                        Ends: {{ $probationStatus['end_date']->format('M d, Y') }}
                                    </small>
                                @endif
                            </div>
                            @if($probationStatus['remaining_days'] !== null && $probationStatus['remaining_days'] > 0)
                                <div class="text-right">
                                    <span class="badge badge-{{ $probationStatus['remaining_days'] <= 30 ? 'warning' : 'primary' }}">
                                        {{ $probationStatus['remaining_days'] }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
                <p><strong>ID:</strong> {{ $incident->id }}</p>
                <p><strong>User:</strong> {{ $incident->user->name ?? 'N/A' }}</p>
                <p><strong>Deceased Name:</strong> {{ $incident->deceased_name }}</p>
                <p><strong>Date of Death:</strong> {{ $incident->date_of_death }}</p>
                <p><strong>Type:</strong> {{ ucfirst($incident->type) }}</p>
                <p><strong>Amount:</strong> {{ number_format($incident->amount, 2) }}</p>
                <p><strong>Status:</strong> {{ $incident->status->name ?? 'N/A' }}</p>
                <p><strong>Verified By:</strong> {{ $incident->verifiedBy->name ?? 'Not Verified' }}</p>

                {{-- Thumbnail --}}
                @if($incident->thumbnail_path)
                    <div class="mb-3">
                        <strong>Thumbnail Image:</strong><br>
                        <img src="{{ Storage::url($incident->thumbnail_path) }}" class="img-thumbnail" style="max-width:200px;">
                    </div>
                @endif

                {{-- Additional Images --}}
                @if($incident->images->count())
                    <div class="mb-3">
                        <strong>Additional Images:</strong>
                        <div class="row mt-2">
                            @foreach($incident->images as $image)
                                <div class="col-md-3 mb-2">
                                    <img src="{{ Storage::url($image->image_path) }}" class="img-thumbnail" style="max-width:100%;">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Description --}}
                <div class="mb-3">
                    <strong>Description:</strong>
                    <p>{{ $incident->description }}</p>
                </div>

                {{-- Action Buttons --}}
                <div class="mt-4">
                    @if(hasPermissionOrRole('update-incident'))
                        <a href="{{ route('admin.incidents.edit', $incident) }}" class="btn btn-primary">
                            <i class="fe fe-edit"></i> Edit
                        </a>
                    @endif

                    @if($isAdmin && !$incident->verified_by && hasPermissionOrRole('update-incident'))
                        <form action="{{ route('admin.incidents.verify', $incident) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success" onclick="return confirm('Verify this incident?')">
                                <i class="fe fe-check"></i> Verify
                            </button>
                        </form>
                    @endif

                    @if(hasPermissionOrRole('delete-incident'))
                        <form action="{{ route('admin.incidents.destroy', $incident) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Delete this incident?')">
                                <i class="fe fe-trash"></i> Delete
                            </button>
                        </form>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
