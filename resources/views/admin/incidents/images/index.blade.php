@extends('admin.layouts.app')

@section('title', 'Event Images')

@section('content')
<div class="page-header">
    <div class="page-leftheader">
        <h4 class="page-title mb-0">Event Images</h4>
    </div>
    <div class="page-rightheader ml-auto d-lg-flex d-none">
    @if(hasPermissionOrRole('create-incident_image'))
        <a href="{{ route('admin.incident-images.create', ['incident_id' => $incident_id]) }}" class="btn btn-primary">
            <i class="fe fe-plus mr-2"></i> Add New Image
        </a>
    @endif
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Event Images List</h3>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table  text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($images as $image)
                                <tr>
                                    <td>{{ $image->id }}</td>
                                    <td>
                                        <img src="{{ asset('storage/' . $image->image_path) }}"
                                             alt="Event Image"
                                             class="img-thumbnail"
                                             style="max-width: 100px;">
                                    </td>
                                    <td>{{ $image->created_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                        <div class="btn-group">
                                            @if(hasPermissionOrRole('read-incident_image'))
                                                <a href="{{ route('admin.incident-images.show', $image) }}"
                                                   class="btn btn-sm text-info" title="View">
                                                    <i class="fe fe-eye"></i>
                                                </a>
                                            @endif
                                            @if(hasPermissionOrRole('update-incident_image'))
                                                <a href="{{ route('admin.incident-images.edit', $image) }}"
                                                   class="btn btn-sm text-primary" title="Edit">
                                                    <i class="fe fe-edit"></i>
                                                </a>
                                            @endif
                                            @if(hasPermissionOrRole('delete-incident_image'))
                                                <form action="{{ route('admin.incident-images.destroy', $image) }}"
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="btn btn-sm text-danger"
                                                            title="Delete"
                                                            onclick="return confirm('Are you sure you want to delete this image?')">
                                                        <i class="fe fe-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No incident images found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $images->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
