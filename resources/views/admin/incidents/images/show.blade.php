@extends('admin.layouts.app')

@section('title', 'View Event Image')

@section('content')
<div class="page-header">
    <div class="page-leftheader">
        <h4 class="page-title mb-0">View Event Image</h4>
    </div>
    <div class="page-rightheader ml-auto d-lg-flex d-none">
        <a href="{{ route('admin.incident-images.index') }}" class="btn btn-secondary">
            <i class="fe fe-arrow-left mr-2"></i> Back to List
        </a>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Event Image Details</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Event</label>
                            <p class="form-control-static">
                                {{ $incidentImage->incident->title ?? 'N/A' }}
                            </p>
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <p class="form-control-static">
                                {{ $incidentImage->description ?? 'No description provided' }}
                            </p>
                        </div>

                        <div class="form-group">
                            <label>Created</label>
                            <p class="form-control-static">
                                {{ $incidentImage->created_at->format('Y-m-d H:i:s') }}
                            </p>
                        </div>

                        <div class="form-group">
                            <label>Last Updated</label>
                            <p class="form-control-static">
                                {{ $incidentImage->updated_at->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Image</label>
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $incidentImage->image_path) }}"
                                     alt="Event Image"
                                     class="img-fluid"
                                     style="max-width: 100%;">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    @if(hasPermissionOrRole('update-incident_image'))
                        <a href="{{ route('admin.incident-images.edit', $incidentImage) }}" class="btn btn-primary">
                            <i class="fe fe-edit mr-2"></i> Edit Image
                        </a>
                    @endif
                    @if(hasPermissionOrRole('delete-incident_image'))
                        <form action="{{ route('admin.incident-images.destroy', $incidentImage) }}"
                              method="POST"
                              class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="btn btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this image?')">
                                <i class="fe fe-trash mr-2"></i> Delete Image
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
