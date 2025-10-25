@extends('admin.layouts.app')

@section('title', 'Create Organization')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Create Organization</h4>
                    </div>
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.payments.organization_store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Organization Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
    <label for="type" class="form-label">Organization Type</label>
    <select class="form-control @error('type') is-invalid @enderror" name="type" required>
        <option value="">Select Type</option>
        
        @foreach ($types as $value)
            {{-- Capitalize the first letter for display (e.g., 'group' becomes 'Group') --}}
            @php
                $label = ucfirst($value);
            @endphp

            <option value="{{ $value }}" {{ old('type') == $value ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
        
    </select>
    @error('type')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

                            <div class="d-flex justify-content-end gap-2">
                                <button type="submit" class="btn btn-primary">Create Organization</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
