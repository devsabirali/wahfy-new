@extends('site.layouts.app')
@section('content')
        <!-- BREADCRUMBS SECTION START -->
        @include('site.layouts.breadcrumbs', [
            'title' => 'Our Team',
            'items' => [
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'Our Team']
            ]
        ])
        <!-- BREADCRUMBS SECTION END -->


        <!-- TEAM SECTION START -->
        <section class="ul-team ul-inner-team ul-section-spacing">
            <div class="ul-container">
                <div class="row row-cols-md-4 row-cols-sm-3 row-cols-2 row-cols-xxs-1 ul-team-row justify-content-center">
                    <!-- single member -->
                    <div class="col">
                        <div class="ul-team-member">
                            <div class="ul-team-member-img">
                                <img src="assets/img/member-1.jpg" alt="Team Member Image">
                                <div class="ul-team-member-socials">
                                    <a href="#"><i class="flaticon-facebook"></i></a>
                                    <a href="#"><i class="flaticon-twitter"></i></a>
                                    <a href="#"><i class="flaticon-linkedin-big-logo"></i></a>
                                    <a href="#"><i class="flaticon-instagram"></i></a>
                                </div>
                            </div>
                            <div class="ul-team-member-info">
                                <h3 class="ul-team-member-name"><a href="team-details.html">John Doe</a></h3>
                                <p class="ul-team-member-designation">Attorney</p>
                            </div>
                        </div>
                    </div>

                    <!-- single member -->
                    <div class="col">
                        <div class="ul-team-member">
                            <div class="ul-team-member-img">
                                <img src="assets/img/member-2.jpg" alt="Team Member Image">
                                <div class="ul-team-member-socials">
                                    <a href="#"><i class="flaticon-facebook"></i></a>
                                    <a href="#"><i class="flaticon-twitter"></i></a>
                                    <a href="#"><i class="flaticon-linkedin-big-logo"></i></a>
                                    <a href="#"><i class="flaticon-instagram"></i></a>
                                </div>
                            </div>
                            <div class="ul-team-member-info">
                                <h3 class="ul-team-member-name"><a href="team-details.html">John Doe</a></h3>
                                <p class="ul-team-member-designation">Attorney</p>
                            </div>
                        </div>
                    </div>

                    <!-- single member -->
                    <div class="col">
                        <div class="ul-team-member">
                            <div class="ul-team-member-img">
                                <img src="assets/img/member-3.jpg" alt="Team Member Image">
                                <div class="ul-team-member-socials">
                                    <a href="#"><i class="flaticon-facebook"></i></a>
                                    <a href="#"><i class="flaticon-twitter"></i></a>
                                    <a href="#"><i class="flaticon-linkedin-big-logo"></i></a>
                                    <a href="#"><i class="flaticon-instagram"></i></a>
                                </div>
                            </div>
                            <div class="ul-team-member-info">
                                <h3 class="ul-team-member-name"><a href="team-details.html">John Doe</a></h3>
                                <p class="ul-team-member-designation">Attorney</p>
                            </div>
                        </div>
                    </div>

                    <!-- single member -->
                    <div class="col">
                        <div class="ul-team-member">
                            <div class="ul-team-member-img">
                                <img src="assets/img/member-4.jpg" alt="Team Member Image">
                                <div class="ul-team-member-socials">
                                    <a href="#"><i class="flaticon-facebook"></i></a>
                                    <a href="#"><i class="flaticon-twitter"></i></a>
                                    <a href="#"><i class="flaticon-linkedin-big-logo"></i></a>
                                    <a href="#"><i class="flaticon-instagram"></i></a>
                                </div>
                            </div>
                            <div class="ul-team-member-info">
                                <h3 class="ul-team-member-name"><a href="team-details.html">John Doe</a></h3>
                                <p class="ul-team-member-designation">Attorney</p>
                            </div>
                        </div>
                    </div>

                    <!-- single member -->
                    <div class="col">
                        <div class="ul-team-member">
                            <div class="ul-team-member-img">
                                <img src="assets/img/member-5.jpg" alt="Team Member Image">
                                <div class="ul-team-member-socials">
                                    <a href="#"><i class="flaticon-facebook"></i></a>
                                    <a href="#"><i class="flaticon-twitter"></i></a>
                                    <a href="#"><i class="flaticon-linkedin-big-logo"></i></a>
                                    <a href="#"><i class="flaticon-instagram"></i></a>
                                </div>
                            </div>
                            <div class="ul-team-member-info">
                                <h3 class="ul-team-member-name"><a href="team-details.html">John Doe</a></h3>
                                <p class="ul-team-member-designation">Attorney</p>
                            </div>
                        </div>
                    </div>

                    <!-- single member -->
                    <div class="col">
                        <div class="ul-team-member">
                            <div class="ul-team-member-img">
                                <img src="assets/img/member-6.jpg" alt="Team Member Image">
                                <div class="ul-team-member-socials">
                                    <a href="#"><i class="flaticon-facebook"></i></a>
                                    <a href="#"><i class="flaticon-twitter"></i></a>
                                    <a href="#"><i class="flaticon-linkedin-big-logo"></i></a>
                                    <a href="#"><i class="flaticon-instagram"></i></a>
                                </div>
                            </div>
                            <div class="ul-team-member-info">
                                <h3 class="ul-team-member-name"><a href="team-details.html">John Doe</a></h3>
                                <p class="ul-team-member-designation">Attorney</p>
                            </div>
                        </div>
                    </div>

                    <!-- single member -->
                    <div class="col">
                        <div class="ul-team-member">
                            <div class="ul-team-member-img">
                                <img src="assets/img/member-7.jpg" alt="Team Member Image">
                                <div class="ul-team-member-socials">
                                    <a href="#"><i class="flaticon-facebook"></i></a>
                                    <a href="#"><i class="flaticon-twitter"></i></a>
                                    <a href="#"><i class="flaticon-linkedin-big-logo"></i></a>
                                    <a href="#"><i class="flaticon-instagram"></i></a>
                                </div>
                            </div>
                            <div class="ul-team-member-info">
                                <h3 class="ul-team-member-name"><a href="team-details.html">John Doe</a></h3>
                                <p class="ul-team-member-designation">Attorney</p>
                            </div>
                        </div>
                    </div>

                    <!-- single member -->
                    <div class="col">
                        <div class="ul-team-member">
                            <div class="ul-team-member-img">
                                <img src="assets/img/member-8.jpg" alt="Team Member Image">
                                <div class="ul-team-member-socials">
                                    <a href="#"><i class="flaticon-facebook"></i></a>
                                    <a href="#"><i class="flaticon-twitter"></i></a>
                                    <a href="#"><i class="flaticon-linkedin-big-logo"></i></a>
                                    <a href="#"><i class="flaticon-instagram"></i></a>
                                </div>
                            </div>
                            <div class="ul-team-member-info">
                                <h3 class="ul-team-member-name"><a href="team-details.html">John Doe</a></h3>
                                <p class="ul-team-member-designation">Attorney</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- TEAM SECTION END -->

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
