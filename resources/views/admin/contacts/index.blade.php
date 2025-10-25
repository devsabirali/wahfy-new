@extends('admin.layouts.app')

@section('title', 'Contact Messages')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        @php
            $breadcrumbs = [
                ['label' => 'Dashboard', 'url' => '/dashboard'],
                ['label' => 'Contact Messages', 'url' => '']
            ];
        @endphp
        @include('admin.layouts.page-title', ['breadcrumbs' => $breadcrumbs])
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Contact Messages</h4>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table  align-middle">
                                <thead class="thead-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Subject</th>
                                        <th>Status</th>
                                        <th>Reply Status</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($contacts as $contact)
                                    <tr>
                                        <td>{{ $contact->id }}</td>
                                        <td>{{ $contact->name }}</td>
                                        <td>{{ $contact->email }}</td>
                                        <td>{{ $contact->subject }}</td>
                                        <td>
                                            @if($contact->is_read)
                                                <span class="badge bg-success">Read</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Unread</span>
                                            @endif
                                        </td>
                                      <td>
                                            @if($contact->reply)
                                                <span class="badge bg-success">Replied</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @endif
                                        </td>
                                        <td>{{ $contact->created_at->format('Y-m-d H:i') }}</td>
                                        <td>
                                            <div class="g-2 d-flex">
                                                <a href="{{ route('admin.contacts.show', $contact) }}"
                                                   class="btn text-info btn-sm"
                                                   data-bs-toggle="tooltip"
                                                   title="View">
                                                    <span class="fe fe-eye fs-14"></span>
                                                </a>
                                                <form action="{{ route('admin.contacts.destroy', $contact) }}"
                                                      method="POST"
                                                      style="display:inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="btn text-danger btn-sm"
                                                            data-bs-toggle="tooltip"
                                                            title="Delete"
                                                            onclick="return confirm('Are you sure you want to delete this message?')">
                                                        <span class="fe fe-trash-2 fs-14"></span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $contacts->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
