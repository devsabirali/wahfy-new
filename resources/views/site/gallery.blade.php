@extends('site.layouts.app')
@section('content')
<!-- BREADCRUMBS SECTION START -->
<section class="ul-breadcrumb ul-section-spacing">
    <div class="ul-container">
        <h2 class="ul-breadcrumb-title">Gallery</h2>
        <ul class="ul-breadcrumb-nav">
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><span class="separator"><i class="flaticon-right"></i></span></li>
            <li>Gallery</li>
        </ul>
    </div>
</section>
<!-- BREADCRUMBS SECTION END -->

<!-- GALLERY SECTION START -->
<section class="ul-projects ul-section-spacing">
    <div class="ul-container"> 
        <div class="row ul-bs-row justify-content-center">
            @foreach($galleries as $gallery)
                <div class="col-lg-4 col-md-6 col-10 col-xxs-12 mb-4">
                    <div class="ul-project ul-project--sm">
                        <div class="ul-project-img">
                            <a href="{{ Storage::url($gallery->image_path) }}" data-lightbox="gallery" data-title="{{ $gallery->title }}">
                                <img src="{{ Storage::url($gallery->image_path) }}" alt="{{ $gallery->title }}">
                            </a>
                        </div>
                        <div class="ul-project-txt">
                            <div>
                                <h3 class="ul-project-title">{{ $gallery->title }}</h3>
                                @if($gallery->description)
                                    <p class="ul-project-descr">{{ $gallery->description }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<!-- GALLERY SECTION END -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/simplelightbox/2.14.1/simple-lightbox.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/simplelightbox/2.14.1/simple-lightbox.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        new SimpleLightbox('[data-lightbox="gallery"]', {});
    });
</script>
@endsection 