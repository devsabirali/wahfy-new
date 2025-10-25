@extends('site.layouts.app')
@section('content')
        <!-- BREADCRUMBS SECTION START -->
        @include('site.layouts.breadcrumbs', [
            'title' => 'Team Member Details',
            'items' => [
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'Our Team', 'url' => route('team')],
                ['label' => 'Team Member Details']
            ]
        ])
        <!-- BREADCRUMBS SECTION END -->

        <div class="ul-section-spacing">
            <div class="ul-container">
                <div class="ul-team-details">
                    <div class="row justify-content-between gx-0 gy-3">
                        <div class="col-md-5">
                            <div class="ul-team-details-img wow animate__fadeInUp">
                                <img src="assets/img/team-details-img.jpg" alt="team member image">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <!-- txt -->
                            <div class="txt wow animate__fadeInUp">
                                <h3 class="ul-team-details-name ul-section-title">Danial Frankie</h3>
                                <h6 class="ul-team-details-role">Co-Founder</h6>
                                <p class="ul-team-details-descr">Adipiscing elit. Mauris viverra nisl quis mollis laoreet. Ut eget lacus a felis accumsan pharetra in dignissim enim. In amet odio mollis urna aliquet volutpat. Sed bibendum nisl vehicula imperdiet imperdiet, augue massa fringilla.</p>

                                <ul class="ul-team-details-infos">
                                    <li class="ul-team-details-info"><a href="tel:2085550112"><i class="flaticon-telephone-call"></i> +208-555-0112</a></li>
                                    <li class="ul-team-details-info"><a href="mailto:thomas.tatum@example.com"><i class="flaticon-email"></i> thomas.tatum@example.com</a></li>
                                </ul>

                                <!-- social links -->
                                <div class="ul-team-details-socials">
                                    <a href="#"><i class="flaticon-facebook"></i></a>
                                    <a href="#"><i class="flaticon-instagram"></i></a>
                                    <a href="#"><i class="flaticon-linkedin-big-logo"></i></a>
                                    <a href="#"><i class="flaticon-twitter-1"></i></a>
                                </div>


                                <div class="ul-team-details-experiences">
                                    <h3 class="ul-donation-details-summary-title">Experience Area</h3>

                                    <div class="experiences-wrapper">
                                        <div class="ul-team-details-experience">
                                            <h6 class="experience-title">Productivity</h6>
                                            <div class="ul-donation-progress-2">
                                                <div class="ul-progress-container">
                                                    <div class="skill-progressbar ul-progressbar" data-ul-progress-value="90">
                                                        <div class="skill-progress-label ul-progress-label">00%</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ul-team-details-experience">
                                            <h6 class="experience-title">Digital Marketing</h6>
                                            <div class="ul-donation-progress-2">
                                                <div class="ul-progress-container">
                                                    <div class="skill-progressbar ul-progressbar" data-ul-progress-value="87">
                                                        <div class="skill-progress-label ul-progress-label">00%</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ul-team-details-experience">
                                            <h6 class="experience-title">Technology</h6>
                                            <div class="ul-donation-progress-2">
                                                <div class="ul-progress-container">
                                                    <div class="skill-progressbar ul-progressbar" data-ul-progress-value="65">
                                                        <div class="skill-progress-label ul-progress-label">00%</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="ul-team-details-contact">
                                    <h3 class="ul-donation-details-summary-title">Message With Me</h3>
                                    <form action="#" class="ul-contact-form ul-form">
                                        <div class="row row-cols-2 row-cols-xxs-1 ul-bs-row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <input type="text" name="name" id="ul-contact-name" placeholder="Your Name">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <input type="email" name="email" id="ul-contact-email" placeholder="Email Address">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <input type="tel" name="phone" id="ul-contact-phone" placeholder="Phone Number">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <textarea name="message" id="ul-contact-msg" placeholder="Type your message"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <button class="ul-btn"><i class="flaticon-fast-forward-double-right-arrows-symbol"></i> Get in Touch</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
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
