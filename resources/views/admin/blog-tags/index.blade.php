@extends('admin.layouts.app')

@section('title', 'Blog Tags')

@section('content')
    @php
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => '/dashboard'],
            ['label' => 'Blog Tags', 'url' => route('admin.blog-tags.index')]
        ];
    @endphp

    @include('admin.layouts.page-title', ['breadcrumbs' => $breadcrumbs])

    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">All Tags</h3> 
                </div>
                <div class="card-body pt-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-bordered text-nowrap mb-0" id="basic-datatable">
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
                                @forelse($tags as $tag)
                                    <tr class="border-bottom">
                                        <td class="text-center">{{ $tag->id }}</td>
                                        <td>{{ $tag->name }}</td>
                                        <td>{{ $tag->slug }}</td>
                                        <td>{{ Str::limit($tag->description, 50) }}</td>
                                        <td>{{ $tag->blogs_count }}</td>
                                        <td>{{ $tag->created_at->format('Y-m-d H:i') }}</td>
                                        <td>
                                            <div class="g-2 d-flex">
                                                <a href="{{ route('admin.blog-tags.edit', $tag) }}"
                                                   class="btn text-primary btn-sm"
                                                   data-bs-toggle="tooltip"
                                                   title="Edit">
                                                    <span class="fe fe-edit fs-14"></span>
                                                </a>
                                                <form action="{{ route('admin.blog-tags.destroy', $tag) }}"
                                                      method="POST"
                                                      style="display:inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="btn text-danger btn-sm"
                                                            data-bs-toggle="tooltip"
                                                            title="Delete"
                                                            onclick="return confirm('Are you sure you want to delete this tag?')">
                                                        <span class="fe fe-trash-2 fs-14"></span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No tags found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($tags->hasPages())
                        <div class="mt-4">
                            {{ $tags->links() }}
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
