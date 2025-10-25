@extends('admin.layouts.app')

@section('title', 'View Contact Message')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        @php
            $breadcrumbs = [
                ['label' => 'Dashboard', 'url' => '/dashboard'],
                ['label' => 'Contact Messages', 'url' => route('admin.contacts.index')],
                ['label' => 'View Message', 'url' => '']
            ];
        @endphp
        @include('admin.layouts.page-title', ['breadcrumbs' => $breadcrumbs])
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">View Contact Message</h4>
                        <div class="card-tools">
                            <a href="{{ route('admin.contacts.index') }}" class="btn btn-light btn-sm">
                                <span class="fe fe-arrow-left fs-14"></span> Back to List
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <h5 class="mb-3">Message Details</h5>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Name</th>
                                        <td>{{ $contact->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $contact->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Subject</th>
                                        <td>{{ $contact->subject }}</td>
                                    </tr>
                                    <tr>
                                        <th>Date</th>
                                        <td>{{ $contact->created_at->format('Y-m-d H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Message</th>
                                        <td>{{ $contact->message }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6 mb-4">
                                <h5 class="mb-3">Reply to Message</h5>
                                <form action="{{ route('admin.contacts.reply', $contact) }}" method="POST">
                                    @csrf
                                    <div class="form-group mb-3">
                                        <label for="reply">Your Reply</label>
                                        <textarea name="reply" id="reply" class="form-control" rows="6" required>{{ old('reply', $contact->reply) }}</textarea>
                                        @error('reply')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-success">
                                        <span class="fe fe-send fs-14"></span> Send Reply
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
