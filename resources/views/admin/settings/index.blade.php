@extends('admin.layouts.app')

@section('title', 'Settings')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        @php
            $breadcrumbs = [
                ['label' => 'Dashboard', 'url' => '/dashboard'],
                ['label' => 'Settings', 'url' => '']
            ];
        @endphp
        @include('admin.layouts.page-title', ['breadcrumbs' => $breadcrumbs])
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Application Settings</h4>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('admin.settings.bulk-update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <ul class="nav nav-tabs" id="settingsTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab" aria-controls="general" aria-selected="true">
                                        General Settings
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="system-tab" data-bs-toggle="tab" data-bs-target="#system" type="button" role="tab" aria-controls="system" aria-selected="false">
                                        System Settings
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="media-tab" data-bs-toggle="tab" data-bs-target="#media" type="button" role="tab" aria-controls="media" aria-selected="false">
                                        Media Settings
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="content-tab" data-bs-toggle="tab" data-bs-target="#content" type="button" role="tab" aria-controls="content" aria-selected="false">
                                        Content Settings
                                    </button>
                                </li>
                            </ul>
                            <div class="tab-content mt-4" id="settingsTabsContent">
                                <!-- General Settings -->
                                <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                                    @if(isset($settings['general']) && count($settings['general']) > 0)
                                        @foreach($settings['general'] as $setting)
                                            <div class="form-group mb-3">
                                                <label for="{{ $setting->key }}" class="form-label">
                                                    {{ ucwords(str_replace('_', ' ', $setting->key)) }}
                                                    @if($setting->is_required)
                                                        <span class="text-danger">*</span>
                                                    @endif
                                                </label>
                                                @if($setting->type === 'textarea')
                                                    <textarea class="form-control @error($setting->key) is-invalid @enderror" id="{{ $setting->key }}" name="{{ $setting->key }}" rows="3">{{ old($setting->key, $setting->value) }}</textarea>
                                                @else
                                                    <input type="{{ $setting->type }}" class="form-control @error($setting->key) is-invalid @enderror" id="{{ $setting->key }}" name="{{ $setting->key }}" value="{{ old($setting->key, $setting->value) }}" @if($setting->is_required) required @endif>
                                                @endif
                                                @error($setting->key)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="alert alert-info">No general settings found.</div>
                                    @endif
                                </div>
                                <!-- System Settings -->
                                <div class="tab-pane fade" id="system" role="tabpanel" aria-labelledby="system-tab">
                                    @if(isset($settings['system']) && count($settings['system']) > 0)
                                        @foreach($settings['system'] as $setting)
                                            <div class="form-group mb-3">
                                                <label for="{{ $setting->key }}" class="form-label">
                                                    {{ ucwords(str_replace('_', ' ', $setting->key)) }}
                                                    @if($setting->is_required)
                                                        <span class="text-danger">*</span>
                                                    @endif
                                                </label>
                                                @if($setting->type === 'select')
                                                    <select class="form-select @error($setting->key) is-invalid @enderror" id="{{ $setting->key }}" name="{{ $setting->key }}" @if($setting->is_required) required @endif>
                                                        @if($setting->key === 'timezone')
                                                            @foreach(timezone_identifiers_list() as $timezone)
                                                                <option value="{{ $timezone }}" {{ old($setting->key, $setting->value) == $timezone ? 'selected' : '' }}>{{ $timezone }}</option>
                                                            @endforeach
                                                        @elseif($setting->key === 'date_format')
                                                            <option value="Y-m-d" {{ old($setting->key, $setting->value) == 'Y-m-d' ? 'selected' : '' }}>YYYY-MM-DD</option>
                                                            <option value="d-m-Y" {{ old($setting->key, $setting->value) == 'd-m-Y' ? 'selected' : '' }}>DD-MM-YYYY</option>
                                                            <option value="m-d-Y" {{ old($setting->key, $setting->value) == 'm-d-Y' ? 'selected' : '' }}>MM-DD-YYYY</option>
                                                        @elseif($setting->key === 'time_format')
                                                            <option value="24" {{ old($setting->key, $setting->value) == '24' ? 'selected' : '' }}>24 Hour</option>
                                                            <option value="12" {{ old($setting->key, $setting->value) == '12' ? 'selected' : '' }}>12 Hour</option>
                                                        @endif
                                                    </select>
                                                @else
                                                    <input type="{{ $setting->type }}" class="form-control @error($setting->key) is-invalid @enderror" id="{{ $setting->key }}" name="{{ $setting->key }}" value="{{ old($setting->key, $setting->value) }}" @if($setting->is_required) required @endif>
                                                @endif
                                                @error($setting->key)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="alert alert-info">No system settings found.</div>
                                    @endif
                                </div>
                                <!-- Media Settings -->
                                <div class="tab-pane fade" id="media" role="tabpanel" aria-labelledby="media-tab">
                                    @if(isset($settings['media']) && count($settings['media']) > 0)
                                        @foreach($settings['media'] as $setting)
                                            <div class="form-group mb-3">
                                                <label for="{{ $setting->key }}" class="form-label">
                                                    {{ ucwords(str_replace('_', ' ', $setting->key)) }}
                                                    @if($setting->is_required)
                                                        <span class="text-danger">*</span>
                                                    @endif
                                                </label>
                                                @if($setting->value)
                                                    <div class="mb-3">
                                                        @if($setting->key === 'logo')
                                                            <img src="{{ Storage::url($setting->value) }}" alt="Current Logo" class="img-thumbnail" style="max-width: 200px;">
                                                        @elseif($setting->key === 'favicon')
                                                            <img src="{{ Storage::url($setting->value) }}" alt="Current Favicon" class="img-thumbnail" style="max-width: 32px;">
                                                        @endif
                                                    </div>
                                                @endif
                                                <input type="file" class="form-control @error($setting->key) is-invalid @enderror" id="{{ $setting->key }}" name="{{ $setting->key }}" accept="image/*">
                                                @error($setting->key)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="alert alert-info">No media settings found.</div>
                                    @endif
                                </div>
                                <!-- Content Settings -->
                                <div class="tab-pane fade" id="content" role="tabpanel" aria-labelledby="content-tab">
                                    @if(isset($settings['content']) && count($settings['content']) > 0)
                                        @foreach($settings['content'] as $setting)
                                            <div class="form-group mb-3">
                                                <label for="{{ $setting->key }}" class="form-label">
                                                    {{ ucwords(str_replace('_', ' ', $setting->key)) }}
                                                    @if($setting->is_required)
                                                        <span class="text-danger">*</span>
                                                    @endif
                                                </label>
                                                <textarea class="form-control @error($setting->key) is-invalid @enderror" id="{{ $setting->key }}" name="{{ $setting->key }}">{{$setting->value}}</textarea>
                                                @error($setting->key)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="alert alert-info">No content settings found.</div>
                                    @endif
                                </div>
                            </div>
                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="{{ route('admin.settings.clear-cache') }}" class="btn btn-light">Clear Cache</a>
                                <button type="submit" class="btn btn-primary">Save Settings</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Bootstrap 5 tabs
        var triggerTabList = [].slice.call(document.querySelectorAll('#settingsTabs button'))
        triggerTabList.forEach(function(triggerEl) {
            var tabTrigger = new bootstrap.Tab(triggerEl)
            triggerEl.addEventListener('click', function(event) {
                event.preventDefault()
                tabTrigger.show()
            })
        })
    });
</script>
@endpush
