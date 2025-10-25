@extends('admin.layouts.app')

@section('title', 'Edit Banner')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        @php
            $breadcrumbs = [
                ['label' => 'Dashboard', 'url' => '/dashboard'],
                ['label' => 'Banners', 'url' => route('admin.banners.index')],
                ['label' => 'Edit Banner', 'url' => '']
            ];
        @endphp
        @include('admin.layouts.page-title', ['breadcrumbs' => $breadcrumbs])
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Edit Banner</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.banners.update', $banner) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $banner->title) }}">
                                    @error('title')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="subtitle" class="form-label">Subtitle</label>
                                    <input type="text" class="form-control @error('subtitle') is-invalid @enderror" id="subtitle" name="subtitle" value="{{ old('subtitle', $banner->subtitle) }}">
                                    @error('subtitle')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="paragraph" class="form-label">Paragraph</label>
                                    <textarea class="form-control @error('paragraph') is-invalid @enderror" id="paragraph" name="paragraph" rows="3">{{ old('paragraph', $banner->paragraph) }}</textarea>
                                    @error('paragraph')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="button_text" class="form-label">Button Text</label>
                                    <input type="text" class="form-control @error('button_text') is-invalid @enderror" id="button_text" name="button_text" value="{{ old('button_text', $banner->button_text) }}">
                                    @error('button_text')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="button_url" class="form-label">Button URL</label>
                                    <input type="url" class="form-control @error('button_url') is-invalid @enderror" id="button_url" name="button_url" value="{{ old('button_url', $banner->button_url) }}">
                                    @error('button_url')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label>Current Background Image</label>
                                    @if($banner->background_image)
                                        <div class="mb-3">
                                            <img src="{{ Storage::url($banner->background_image) }}" alt="Current Background" class="img-thumbnail" style="max-width: 200px;">
                                        </div>
                                    @endif
                                    <label for="background_image" class="form-label">Update Background Image</label>
                                    <input type="file" class="form-control @error('background_image') is-invalid @enderror" id="background_image" name="background_image" accept="image/*">
                                    <small class="form-text text-muted">Maximum file size: 2MB</small>
                                    @error('background_image')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="status_id" class="form-label">Status</label>
                                    <select class="form-control @error('status_id') is-invalid @enderror" id="status_id" name="status_id">
                                        <option value="">Select Status</option>
                                        @foreach($statuses as $status)
                                            <option value="{{ $status->id }}" {{ old('status_id', $banner->status_id) == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('status_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.banners.index') }}" class="btn btn-light">Cancel</a>
                                <button type="submit" class="btn btn-primary">Update Banner</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
