@extends('admin.layouts.app')

@section('title', 'Blog Posts')

@section('content')
    @php
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => '/dashboard'],
            ['label' => 'Blog', 'url' => route('admin.blogs.index')]
        ];
    @endphp

    @include('admin.layouts.page-title', ['breadcrumbs' => $breadcrumbs])

    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">All Blog Posts</h3>
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
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Categories</th>
                                    <th>Tags</th>
                                    <th>Status</th>
                                    <th style="width: 15%;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($blogs as $blog)
                                    <tr class="border-bottom">
                                        <td class="text-center">{{ $blog->id }}</td>
                                        <td>
                                            @if($blog->image)
                                                <img src="{{ route('admin.blogs.image', ['path' => $blog->image]) }}"
                                                     alt="{{ $blog->title }}"
                                                     class="img-thumbnail"
                                                     style="max-width: 50px;">
                                            @else
                                                <span class="badge bg-light">No Image</span>
                                            @endif
                                        </td>
                                        <td>{{ $blog->title }}</td>
                                        <td>
                                            @if($blog->categories->count() > 0)
                                                @foreach($blog->categories as $category)
                                                    <span class="badge bg-primary">{{ $category->name }}</span>
                                                @endforeach
                                            @else
                                                <span class="badge bg-light">Uncategorized</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($blog->tags->count() > 0)
                                                @foreach($blog->tags as $tag)
                                                    <span class="badge bg-info">{{ $tag->name }}</span>
                                                @endforeach
                                            @else
                                                <span class="badge bg-light">No Tags</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge text-success">
                                                Active
                                            </span>
                                            {{-- <span class="badge bg-{{ $blog->status === 'published' ? 'success' : 'warning' }}">
                                                {{ ucfirst($blog->status) }}
                                            </span> --}}
                                        </td>
                                        <td>
                                            <div class="g-2 d-flex">
                                                <a href="{{ route('admin.blogs.edit', $blog) }}"
                                                   class="btn text-primary btn-sm"
                                                   data-bs-toggle="tooltip"
                                                   title="Edit">
                                                    <span class="fe fe-edit fs-14"></span>
                                                </a>
                                                <a href="{{ route('admin.blogs.show', $blog) }}"
                                                   class="btn text-info btn-sm"
                                                   data-bs-toggle="tooltip"
                                                   title="View">
                                                    <span class="fe fe-eye fs-14"></span>
                                                </a>
                                                <form action="{{ route('admin.blogs.destroy', $blog) }}"
                                                      method="POST"
                                                      style="display:inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="btn text-danger btn-sm"
                                                            data-bs-toggle="tooltip"
                                                            title="Delete"
                                                            onclick="return confirm('Are you sure you want to delete this blog post?')">
                                                        <span class="fe fe-trash-2 fs-14"></span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No blog posts found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($blogs->hasPages())
                        <div class="mt-4">
                            {{ $blogs->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .img-thumbnail {
        padding: 0.25rem;
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
        max-width: 100%;
        height: auto;
    }
    .badge {
        margin-right: 0.25rem;
    }
</style>
@endpush

@push('scripts')
<script src="{{ asset('admin/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin/plugins/datatable/js/dataTables.bootstrap5.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#basic-datatable').DataTable({
            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
                lengthMenu: '_MENU_',
            }
        });
    });
</script>
@endpush
