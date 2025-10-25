@extends('admin.layouts.app')

@section('title', 'Banners')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        @php
            $breadcrumbs = [
                ['label' => 'Dashboard', 'url' => '/dashboard'],
                ['label' => 'Banners', 'url' => '']
            ];
        @endphp
        @include('admin.layouts.page-title', ['breadcrumbs' => $breadcrumbs])
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Banners List</h4>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table text-nowrap align-middle">
                                <thead class="thead-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th> 
                                        <th>Background Image</th>
                                        <th>Status</th> 
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($banners as $banner)
                                        <tr>
                                            <td>{{ $banner->id }}</td>
                                            <td>{{ $banner->title }}</td> 
                                            <td>
                                                @if($banner->background_image)
                                                    <img src="{{ Storage::url($banner->background_image) }}"
                                                         alt="Banner Image"
                                                         class="img-thumbnail"
                                                         style="max-width: 100px;">
                                                @else
                                                    <span class="badge bg-light">No Image</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $banner->status?->name === 'Active' ? 'success' : 'danger' }}">
                                                    {{ $banner->status?->name }}
                                                </span>
                                            </td> 
                                            <td>
                                                <div class="g-2 d-flex">
                                                    <a href="{{ route('admin.banners.edit', $banner) }}"
                                                       class="btn text-primary btn-sm"
                                                       data-bs-toggle="tooltip"
                                                       title="Edit">
                                                        <span class="fe fe-edit fs-14"></span>
                                                    </a>
                                                    <form action="{{ route('admin.banners.destroy', $banner) }}"
                                                          method="POST"
                                                          style="display:inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="btn text-danger btn-sm"
                                                                data-bs-toggle="tooltip"
                                                                title="Delete"
                                                                onclick="return confirm('Are you sure you want to delete this banner?')">
                                                            <span class="fe fe-trash-2 fs-14"></span>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">No banners found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $banners->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
