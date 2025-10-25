@extends('admin.layouts.app')

@section('title', 'Blog Categories')

@section('content')
    @php
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => '/dashboard'],
            ['label' => 'Blog Categories', 'url' => route('admin.blog-categories.index')]
        ];
    @endphp

    @include('admin.layouts.page-title', ['breadcrumbs' => $breadcrumbs])

    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">All Categories</h3> 
                </div>
                <div class="card-body pt-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-bordered text-nowrap mb-0">
                            <thead class="border-top">
                                <tr>
                                    <th style="width: 5%;">ID</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Description</th>
                                    <th>Blogs</th>
                                    <th>Created</th>
                                    <th style="width: 15%;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $category)
                                    <tr class="border-bottom">
                                        <td class="text-center">{{ $category->id }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->slug }}</td>
                                        <td>{{ Str::limit($category->description, 50) }}</td>
                                        <td>{{ $category->blogs_count }}</td>
                                        <td>{{ $category->created_at->format('Y-m-d H:i') }}</td>
                                        <td>
                                            <div class="g-2 d-flex">
                                                <a href="{{ route('admin.blog-categories.edit', $category) }}"
                                                   class="btn text-primary btn-sm"
                                                   data-bs-toggle="tooltip"
                                                   title="Edit">
                                                    <span class="fe fe-edit fs-14"></span>
                                                </a>
                                                <form action="{{ route('admin.blog-categories.destroy', $category) }}"
                                                      method="POST"
                                                      style="display:inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="btn text-danger btn-sm"
                                                            data-bs-toggle="tooltip"
                                                            title="Delete"
                                                            onclick="return confirm('Are you sure you want to delete this category?')">
                                                        <span class="fe fe-trash-2 fs-14"></span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No categories found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($categories->hasPages())
                        <div class="mt-4">
                            {{ $categories->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .badge {
        margin-right: 0.25rem;
    }
</style>
@endpush
