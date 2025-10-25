@extends('admin.layouts.app')

@section('title', 'Add Event Image')

@section('content')
<div class="page-header">
    <div class="page-leftheader">
        <h4 class="page-title mb-0">Add Event Image</h4>
    </div>
    <div class="page-rightheader ml-auto d-lg-flex d-none">
        <a href="{{ route('admin.incident-images.index', ['incident_id' => $incidentId ?? null]) }}" class="btn btn-secondary">
            <i class="fe fe-arrow-left mr-2"></i> Back to List
        </a>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add New Event Image</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.incident-images.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="incident_id">Event <span class="text-danger">*</span></label>
                        <select name="incident_id" id="incident_id" class="form-control @error('incident_id') is-invalid @enderror" required>
                            <option value="">Select Event</option>
                            @foreach($incidents as $incident)
                                <option value="{{ $incident->id }}"
                                    {{ old('incident_id', $incidentId ?? '') == $incident->id ? 'selected' : '' }}>
                                    {{ $incident->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('incident_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="image_path">Image <span class="text-danger">*</span></label>
                        <input type="file"
                               name="image_path"
                               id="image_path"
                               class="form-control @error('image_path') is-invalid @enderror"
                               accept="image/*"
                               required>
                        @error('image_path')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
{{--
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description"
                                  id="description"
                                  class="form-control @error('description') is-invalid @enderror"
                                  rows="3">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div> --}}

                    <div class="form-group">
                        @if(hasPermissionOrRole('create-incident_image'))
                            <button type="submit" class="btn btn-primary">
                                <i class="fe fe-save mr-2"></i> Save Image
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
