@extends('site.layouts.app')
@section('content')
        <!-- BREADCRUMBS SECTION START -->
        @include('site.layouts.breadcrumbs', [
            'title' => 'Our Services',
            'items' => [
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'Our Services']
            ]
        ])
        <!-- BREADCRUMBS SECTION END -->


        <!-- SERVICES SECTION START -->
        <section class=" ul-section-spacing overflow-hidden">
            <div class="ul-container">
                <div class="row row-cols-md-3 row-cols-2 row-cols-xxs-1 ul-bs-row">
                    <!-- single slide -->
                    <div class="col">
                        <div class="ul-service ul-service--inner">
                            <div class="ul-service-img">
                                <img src="assets/img/service-1.jpg" alt="Service Image">
                            </div>
                            <div class="ul-service-txt">
                                <h3 class="ul-service-title"><a href="service-details.html">Fund Raised & Donation</a></h3>
                                <p class="ul-service-descr">Professional Detailed Residential Cleaning, Ensuring Spotless Homes And Healthy Living Spaces.</p>
                                <a href="service-details.html" class="ul-service-btn"><i class="flaticon-up-right-arrow"></i> View Details</a>
                            </div>
                        </div>
                    </div>

                    <!-- single slide -->
                    <div class="col">
                        <div class="ul-service ul-service--inner">
                            <div class="ul-service-img">
                                <img src="assets/img/service-2.jpg" alt="Service Image">
                            </div>
                            <div class="ul-service-txt">
                                <h3 class="ul-service-title"><a href="service-details.html">Medical Treatment Help</a></h3>
                                <p class="ul-service-descr">Professional Detailed Residential Cleaning, Ensuring Spotless Homes And Healthy Living Spaces.</p>
                                <a href="service-details.html" class="ul-service-btn"><i class="flaticon-up-right-arrow"></i> View Details</a>
                            </div>
                        </div>
                    </div>

                    <!-- single slide -->
                    <div class="col">
                        <div class="ul-service ul-service--inner">
                            <div class="ul-service-img">
                                <img src="assets/img/service-3.jpg" alt="Service Image">
                            </div>
                            <div class="ul-service-txt">
                                <h3 class="ul-service-title"><a href="service-details.html">Child Medical Research</a></h3>
                                <p class="ul-service-descr">Professional Detailed Residential Cleaning, Ensuring Spotless Homes And Healthy Living Spaces.</p>
                                <a href="service-details.html" class="ul-service-btn"><i class="flaticon-up-right-arrow"></i> View Details</a>
                            </div>
                        </div>
                    </div>

                    <!-- single slide -->
                    <div class="col">
                        <div class="ul-service ul-service--inner">
                            <div class="ul-service-img">
                                <img src="assets/img/service-4.jpg" alt="Service Image">
                            </div>
                            <div class="ul-service-txt">
                                <h3 class="ul-service-title"><a href="service-details.html">Development Programs</a></h3>
                                <p class="ul-service-descr">Professional Detailed Residential Cleaning, Ensuring Spotless Homes And Healthy Living Spaces.</p>
                                <a href="service-details.html" class="ul-service-btn"><i class="flaticon-up-right-arrow"></i> View Details</a>
                            </div>
                        </div>
                    </div>

                    <!-- single slide -->
                    <div class="col">
                        <div class="ul-service ul-service--inner">
                            <div class="ul-service-img">
                                <img src="assets/img/service-1.jpg" alt="Service Image">
                            </div>
                            <div class="ul-service-txt">
                                <h3 class="ul-service-title"><a href="service-details.html">Fund Raised & Donation</a></h3>
                                <p class="ul-service-descr">Professional Detailed Residential Cleaning, Ensuring Spotless Homes And Healthy Living Spaces.</p>
                                <a href="service-details.html" class="ul-service-btn"><i class="flaticon-up-right-arrow"></i> View Details</a>
                            </div>
                        </div>
                    </div>

                    <!-- single slide -->
                    <div class="col">
                        <div class="ul-service ul-service--inner">
                            <div class="ul-service-img">
                                <img src="assets/img/service-2.jpg" alt="Service Image">
                            </div>
                            <div class="ul-service-txt">
                                <h3 class="ul-service-title"><a href="service-details.html">Medical Treatment Help</a></h3>
                                <p class="ul-service-descr">Professional Detailed Residential Cleaning, Ensuring Spotless Homes And Healthy Living Spaces.</p>
                                <a href="service-details.html" class="ul-service-btn"><i class="flaticon-up-right-arrow"></i> View Details</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <!-- SERVICES SECTION END -->


        <!-- WHY JOIN SECTION START -->
        <section class="ul-why-join ul-section-spacing pt-0">
            <div class="ul-why-join-wrapper ul-section-spacing">
                <div class="ul-container">
                    <div class="row row-cols-md-2 row-cols-1 gy-4 align-items-center">
                        <div class="col">
                            <div class="ul-why-join-img">
                                <img src="assets/img/why-join.jpg" alt="Image">
                            </div>
                        </div>

                        <!-- txt -->
                        <div class="col">
                            <div class="ul-why-join-txt">
                                <span class="ul-section-sub-title">Join us</span>
                                <h2 class="ul-section-title">Why We Need You Become a Volunteer</h2>
                                <p class="ul-section-descr">We help companies develop powerful corporate social responsibility, grantmaking, and employee engagement strategies.</p>

                                <div class="ul-accordion">
                                    <div class="ul-single-accordion-item open">
                                        <div class="ul-single-accordion-item__header">
                                            <div class="left">
                                                <h3 class="ul-single-accordion-item__title">Recognition and Fulfillment</h3>
                                            </div>
                                            <span class="icon"><i class="flaticon-next"></i></span>
                                        </div>

                                        <div class="ul-single-accordion-item__body">
                                            <p>Aonsectetur adipiscing elit Aenean scelerisque augue vitae consequat Juisque eget congue velit in cursus leo sodales the turpis euismod quis sapien euismod quis sapien the. E-learning is suitable for students, professionals, and anyone interested.</p>
                                        </div>
                                    </div>

                                    <div class="ul-single-accordion-item">
                                        <div class="ul-single-accordion-item__header">
                                            <div class="left">
                                                <h3 class="ul-single-accordion-item__title">Why Join Us as a Volunteer?</h3>
                                            </div>
                                            <span class="icon"><i class="flaticon-next"></i></span>
                                        </div>

                                        <div class="ul-single-accordion-item__body">
                                            <p>Aonsectetur adipiscing elit Aenean scelerisque augue vitae consequat Juisque eget congue velit in cursus leo sodales the turpis euismod quis sapien euismod quis sapien the. E-learning is suitable for students, professionals, and anyone interested.</p>
                                        </div>
                                    </div>

                                    <div class="ul-single-accordion-item">
                                        <div class="ul-single-accordion-item__header">
                                            <div class="left">
                                                <h3 class="ul-single-accordion-item__title">Be Part of a Community</h3>
                                            </div>
                                            <span class="icon"><i class="flaticon-next"></i></span>
                                        </div>

                                        <div class="ul-single-accordion-item__body">
                                            <p>Aonsectetur adipiscing elit Aenean scelerisque augue vitae consequat Juisque eget congue velit in cursus leo sodales the turpis euismod quis sapien euismod quis sapien the. E-learning is suitable for students, professionals, and anyone interested.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- WHY JOIN SECTION END -->

    <!-- FOOTER SECTION END -->

    <!-- libraries JS -->
    <script src="assets/vendor/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/splide/splide.min.js"></script>
    <script src="assets/vendor/splide/splide-extension-auto-scroll.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/slim-select/slimselect.min.js"></script>
    <script src="assets/vendor/animate-wow/wow.min.js"></script>
    <script src="assets/vendor/splittype/index.min.js"></script>
    <script src="assets/vendor/mixitup/mixitup.min.js"></script>
    <script src="assets/vendor/fslightbox/fslightbox.js"></script>
    <script src="assets/vendor/flatpickr/flatpickr.js"></script>

    <!-- custom JS -->
    <script src="assets/js/main.js"></script>
    <script src="assets/js/tab.js"></script>
    <!-- <script src="assets/js/countdown.js"></script> -->
    <script src="assets/js/accordion.js"></script>
    <script src="assets/js/progressbar.js"></script>
@endsection
