@extends('site.layouts.app')
@section('content')
        <!-- BREADCRUMBS SECTION START -->
        @include('site.layouts.breadcrumbs', [
            'title' => 'About Us',
            'items' => [
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'About Us']
            ]
        ])
        <!-- BREADCRUMBS SECTION END -->

        @php
            $about = get_static('about', 'about-section');
        @endphp
        <!-- ABOUT SECTION START -->
        <section class="ul-about ul-section-spacing wow animate__fadeInUp">
            <div class="ul-container">
                <div class="row row-cols-md-2 row-cols-1 align-items-center gy-4 ul-about-row">
                    <div class="col">
                        <div class="ul-about-imgs">
                            <div class="img-wrapper">
                                <img src="{{ asset($about['image']) }}" alt="Image">
                            </div>
                            <div class="ul-about-imgs-vectors">
                                <img src="{{ asset($about['vectors'][0]) }}" alt="Image" class="vector-1">
                                <img src="{{ asset($about['vectors'][1]) }}" alt="Image" class="vector-2">
                            </div>
                        </div>
                    </div>
                    <!-- txt -->
                    <div class="col">
                        <div class="ul-about-txt">
                            <span class="ul-section-sub-title ul-section-sub-title--2">{{ $about['title'] }}</span>
                            <h2 class="ul-section-title">{{ $about['subtitle'] }}</h2>
                            <p class="ul-section-descr">{{ $about['description'] }}</p>
                            <div class="ul-about-block">
                                <div class="block-left">
                                    <div class="block-heading">
                                        <!-- <div class="icon"><i class="{{ $about['block']['left']['icon'] }}"></i></div> -->
                                        <h3 class="block-title">{{ $about['block']['left']['title'] }}</h3>
                                    </div>
                                    <ul class="block-list">
                                        @foreach($about['block']['left']['list'] as $item)
                                            <li>{{ $item }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                <!-- <div class="block-right"><img src="{{ asset($about['block']['right_image']) }}" alt="Image"></div> -->
                            </div>
                            <div class="ul-about-bottom">
                                <a href="{{ $about['button']['url'] }}" class="ul-btn"><i class="flaticon-fast-forward-double-right-arrows-symbol"></i> {{ $about['button']['text'] }}</a>
                                <div class="ul-about-call">
                                    <div class="icon"><i class="{{ $about['call']['icon'] }}"></i></div>
                                    <div class="txt">
                                        <span class="call-title">{{ $about['call']['title'] }}</span>
                                        <a href="tel:{{ get_phone() }}">{{ get_phone() }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- vector -->
            <div class="ul-about-vectors">
                <!-- <img src="{{ asset($about['vectors_bg'][0]) }}" alt="vector" class="vector-1"> -->
            </div>
        </section>
        <!-- ABOUT SECTION END -->


        

    {{-- <script src="assets/vendor/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/splide/splide.min.js"></script>
    <script src="assets/vendor/splide/splide-extension-auto-scroll.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/slim-select/slimselect.min.js"></script>
    <script src="assets/vendor/animate-wow/wow.min.js"></script>
    <script src="assets/vendor/splittype/index.min.js"></script>
    <script src="assets/vendor/mixitup/mixitup.min.js"></script>
    <script src="assets/vendor/fslightbox/fslightbox.js"></script>
    <script src="assets/vendor/flatpickr/flatpickr.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/tab.js"></script>
    <script src="assets/js/accordion.js"></script>
    <script src="assets/js/progressbar.js"></script> --}}
@endsection
