@extends('admin.layouts.app')

@section('title', 'Add Payment Method')

@section('content')
<div class="page-content">
    <div class="container-fluid">

        @php
            $breadcrumbs = [
                ['label' => 'Dashboard', 'url' => '/dashboard'],
                ['label' => 'Payment Methods', 'url' => route('admin.payment-methods.index')],
                ['label' => 'Add Payment Method', 'url' => '']
            ];
        @endphp

        @include('admin.layouts.page-title', ['breadcrumbs' => $breadcrumbs])

        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-header">
                        <h4 class="card-title">Add New Payment Method</h4>
                    </div>

                    <div class="card-body">

                        {{-- Validation Errors --}}
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Form --}}
                        <form action="{{ route('admin.payment-methods.store') }}" method="POST">
                            @csrf

                            {{-- Name Field --}}
                            <div class="mb-3">
                                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       id="name"
                                       name="name"
                                       value="{{ old('name') }}"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Active Checkbox --}}
                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="checkbox"
                                           class="form-check-input @error('is_active') is-invalid @enderror"
                                           id="is_active"
                                           name="is_active"
                                           value="1"
                                           {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">Active</label>
                                    @error('is_active')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Form Buttons --}}
                            <div class="text-end">
                                <a href="{{ route('admin.payment-methods.index') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Add Payment Method</button>
                            </div>

                        </form>
                        {{-- End Form --}}

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
