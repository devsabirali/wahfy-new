@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Setting</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.settings.update', $setting) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="key">Key</label>
                            <input type="text" class="form-control" id="key" value="{{ $setting->key }}" disabled>
                            <small class="form-text text-muted">Key cannot be changed after creation</small>
                        </div>

                        <div class="form-group">
                            <label for="label">Label</label>
                            <input type="text" class="form-control @error('label') is-invalid @enderror" id="label" name="label" value="{{ old('label', $setting->label) }}" required>
                            @error('label')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="type">Type</label>
                            <select class="form-control @error('type') is-invalid @enderror" id="type" name="type" required>
                                <option value="text" {{ $setting->type === 'text' ? 'selected' : '' }}>Text</option>
                                <option value="textarea" {{ $setting->type === 'textarea' ? 'selected' : '' }}>Textarea</option>
                                <option value="file" {{ $setting->type === 'file' ? 'selected' : '' }}>File</option>
                                <option value="number" {{ $setting->type === 'number' ? 'selected' : '' }}>Number</option>
                                <option value="boolean" {{ $setting->type === 'boolean' ? 'selected' : '' }}>Boolean</option>
                            </select>
                            @error('type')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="group">Group</label>
                            <input type="text" class="form-control @error('group') is-invalid @enderror" id="group" name="group" value="{{ old('group', $setting->group) }}" required>
                            @error('group')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="value">Value</label>
                            @if($setting->type === 'textarea')
                                <textarea class="form-control @error('value') is-invalid @enderror" id="value" name="value" required>{{ old('value', $setting->value) }}</textarea>
                            @elseif($setting->type === 'boolean')
                                <select class="form-control @error('value') is-invalid @enderror" id="value" name="value" required>
                                    <option value="1" {{ $setting->value ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{ !$setting->value ? 'selected' : '' }}>No</option>
                                </select>
                            @elseif($setting->type === 'file')
                                @if($setting->value)
                                    <div class="mb-2">
                                        <img src="{{ Storage::url($setting->value) }}" alt="Current file" class="img-thumbnail" style="max-height: 100px;">
                                    </div>
                                @endif
                                <input type="file" class="form-control @error('value') is-invalid @enderror" id="value" name="value">
                            @else
                                <input type="{{ $setting->type === 'number' ? 'number' : 'text' }}" class="form-control @error('value') is-invalid @enderror" id="value" name="value" value="{{ old('value', $setting->value) }}" required>
                            @endif
                            @error('value')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ old('description', $setting->description) }}</textarea>
                            @error('description')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Update Setting</button>
                        <a href="{{ route('admin.settings.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
