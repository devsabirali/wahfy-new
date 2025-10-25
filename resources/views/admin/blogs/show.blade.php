@extends('admin.layouts.app')

@section('title', 'View Blog')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        @php
            $breadcrumbs = [
                ['label' => 'Dashboard', 'url' => '/dashboard'],
                ['label' => 'Blogs', 'url' => route('admin.blogs.index')],
                ['label' => 'View Blog', 'url' => '']
            ];
        @endphp
        @include('admin.layouts.page-title', ['breadcrumbs' => $breadcrumbs])

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Blog Details</h4>
                        <a href="{{ route('admin.blogs.edit', $blog) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <h5>Title</h5>
                            <p>{{ $blog->title }}</p>
                        </div>

                        <div class="mb-3">
                            <h5>Categories</h5>
                            <p>
                                @foreach($blog->categories as $category)
                                    <span class="badge bg-info text-dark">{{ $category->name }}</span>
                                @endforeach
                            </p>
                        </div>

                        <div class="mb-3">
                            <h5>Tags</h5>
                            <p>
                                @foreach($blog->tags as $tag)
                                    <span class="badge bg-secondary">{{ $tag->name }}</span>
                                @endforeach
                            </p>
                        </div>

                        <div class="mb-3">
                            <h5>Description</h5>
                            <p>{{ $blog->description }}</p>
                        </div>

                        <div class="mb-3">
                            <h5>Content</h5>
                            <div>{!! $blog->content !!}</div>
                        </div>

                        <div class="mb-3">
                            <h5>Featured Image</h5>
                            @if($blog->image)
                                <img src="{{ asset('storage/' . $blog->image) }}"
                                     alt="Featured Image"
                                     class="img-thumbnail"
                                     style="max-height: 250px;">
                            @else
                                <p>No image uploaded.</p>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.blogs.index') }}" class="btn btn-light">Back</a>
                        <a href="{{ route('admin.blogs.edit', $blog) }}" class="btn btn-primary">Edit Blog</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
