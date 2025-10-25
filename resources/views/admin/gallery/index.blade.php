@extends('admin.layouts.app')

@section('content')
    @php
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => '/dashboard'],
            ['label' => 'Gallery', 'url' => route('admin.gallery.index')]
        ];
    @endphp

    @include('admin.layouts.page-title', ['breadcrumbs' => $breadcrumbs])

    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                     <h3 class="card-title mb-0">Gallery Images</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Add Gallery
                        </a>
                    </div>
                </div>

                <div class="card-body pt-4">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-bordered text-nowrap mb-0">
                            <thead class="border-top">
                                <tr>
                                    <th class="bg-transparent border-bottom-0" style="width: 10%;">Image</th>
                                    <th class="bg-transparent border-bottom-0">Title</th>
                                    <th class="bg-transparent border-bottom-0">Description</th>
                                    <th class="bg-transparent border-bottom-0" style="width: 15%;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($galleries as $gallery)
                                    <tr class="border-bottom">
                                        <td><img src="{{ Storage::url($gallery->image_path) }}" width="100"></td>
                                        <td>{{ $gallery->title }}</td>
                                        <td>{{ $gallery->description }}</td>
                                        <td>
                                            <div class="g-2 d-flex">
                                                <a href="{{ route('admin.gallery.edit', $gallery) }}" class="btn text-warning btn-sm" data-bs-toggle="tooltip" title="Edit">
                                                    <span class="fe fe-edit fs-14"></span>
                                                </a>
                                                <form action="{{ route('admin.gallery.destroy', $gallery) }}" method="POST" style="display:inline;">
                                                    @csrf @method('DELETE')
                                                    <button class="btn text-danger btn-sm" data-bs-toggle="tooltip" title="Delete" onclick="return confirm('Delete this image?')">
                                                        <span class="fe fe-trash-2 fs-14"></span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No images found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $galleries->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
