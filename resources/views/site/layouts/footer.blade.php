  <!-- FOOTER SECTION START -->
    <footer class="ul-footer">
        <div class="ul-footer-top">
            <div class="ul-footer-container">
                <div class="ul-footer-top-contact-infos">
                    <!-- single info -->
                    <div class="ul-footer-top-contact-info">
                        <!-- icon -->
                        <div class="ul-footer-top-contact-info-icon">
                            <div class="ul-footer-top-contact-info-icon-inner">
                                <i class="flaticon-pin"></i>
                            </div>
                        </div>
                        <!-- txt -->
                        <div class="ul-footer-top-contact-info-txt">
                            <span class="ul-footer-top-contact-info-label">Address</span>
                            <h5 class="ul-footer-top-contact-info-address">{{ get_address() }}</h5>
                        </div>
                    </div>

                    <!-- single info -->
                    <div class="ul-footer-top-contact-info">
                        <!-- icon -->
                        <div class="ul-footer-top-contact-info-icon">
                            <div class="ul-footer-top-contact-info-icon-inner">
                                <i class="flaticon-email"></i>
                            </div>
                        </div>
                        <!-- txt -->
                        <div class="ul-footer-top-contact-info-txt">
                            <span class="ul-footer-top-contact-info-label">Send Email</span>
                            <h5 class="ul-footer-top-contact-info-address"><a href="mailto:{{ get_email() }}">{{ get_email() }}</a></h5>
                        </div>
                    </div>

                    <!-- single info -->
                    <div class="ul-footer-top-contact-info">
                        <!-- icon -->
                        <div class="ul-footer-top-contact-info-icon">
                            <div class="ul-footer-top-contact-info-icon-inner">
                                <i class="flaticon-telephone-call-1"></i>
                            </div>
                        </div>
                        <!-- txt -->
                        <div class="ul-footer-top-contact-info-txt">
                            <span class="ul-footer-top-contact-info-label">Call Emergency</span>
                            <h5 class="ul-footer-top-contact-info-address"><a href="tel:{{ get_phone() }}">{{ get_phone() }}</a></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="ul-footer-middle">
            <div class="ul-footer-container">
                <div class="ul-footer-middle-wrapper wow animate__fadeInUp">
                    <div class="ul-footer-about">
                        <img src="{{ Storage::url(get_logo()) }}" alt="logo" width="200px" class="logo">
                        <p class="ul-footer-about-txt">{{get_description()}}</p>
                        <div class="ul-footer-socials">
                            <a href="#"><i class="flaticon-facebook"></i></a>
                            <a href="#"><i class="flaticon-twitter"></i></a>
                            <a href="#"><i class="flaticon-linkedin-big-logo"></i></a>
                            <a href="#"><i class="flaticon-youtube"></i></a>
                        </div>
                    </div>

                    <div class="ul-footer-widget">
                        <h3 class="ul-footer-widget-title">Quick Links</h3>
                        <div class="ul-footer-widget-links">
                            <a href="{{ url('/') }}" >Home</a>
                            <a href="{{ route('about') }}">About</a>
                            <a href="{{ route('donation') }}" >Donations</a>
                            <a href="{{ route('gallery') }}" >Gallery</a>
                            <a href="{{ route('blog') }}" >Blog</a>
                            <a href="{{ route('contact') }}">Contact</a>
                        </div>
                    </div>

                    <div class="ul-footer-widget ul-footer-recent-posts">
                        <h3 class="ul-footer-widget-title">Recent Posts</h3>

                        <div class="ul-blog-sidebar-posts">
                            @php
                                $recentPosts = \App\Models\Blog::with('author')
                                    ->where('status', true)
                                    ->latest()
                                    ->take(2)
                                    ->get();
                            @endphp

                            @foreach($recentPosts as $post)
                            <!-- single post -->
                            <div class="ul-blog-sidebar-post ul-footer-post">
                                <div class="img">
                                    <img src="{{ Storage::url($post->image) }}" alt="{{ $post->title }}">
                                </div>

                                <div class="txt">
                                    <span class="date">
                                        <span class="icon"><i class="flaticon-calendar"></i></span>
                                        <span>{{ $post->created_at->format('M d, Y') }}</span>
                                    </span>

                                    <h4 class="title">
                                        <a href="{{ route('blog.detail', ['blog' => $post->slug]) }}">{{ $post->title }}</a>
                                    </h4>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="ul-footer-widget ul-nwsltr-widget">
                        <h3 class="ul-footer-widget-title">Contact Us</h3>
                        <div class="ul-footer-widget-links ul-footer-contact-links">
                            <a href="mailto:{{ get_email() }}"><i class="flaticon-mail"></i> {{ get_email() }}</a>
                            <a href="tel:{{ get_phone() }}"><i class="flaticon-telephone-call"></i> {{ get_phone() }}</a>
                        </div>
                        <form action="#" class="ul-nwsltr-form">
                            <div class="top">
                                <input type="email" name="email" id="nwsltr-email" placeholder="Your Email Address" class="ul-nwsltr-input">
                                <button type="submit"><i class="flaticon-next"></i></button>
                            </div>

                            <div class="agreement">
                                <label for="nwsltr-agreement" class="ul-checkbox-wrapper">
                                    <input type="checkbox" name="agreement" id="nwsltr-agreement" hidden>
                                    <span class="ul-checkbox"><i class="flaticon-tick"></i></span>
                                    <span class="ul-checkbox-txt">I agree with the <a href="#">Privacy Policy</a></span>
                                </label>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- footer bottom -->
        <div class="ul-footer-bottom">
            <div class="ul-footer-container">
                <div class="ul-footer-bottom-wrapper">
                    <p class="copyright-txt">&copy;
                        <span id="footer-copyright-year"></span> {{ config('app.name', 'Laravel') }}. All rights reserved
                    </p>
                    <div class="ul-footer-bottom-nav"><a href="#">Terms & Conditions</a> <a href="#">Privacy Policy</a></div>
                </div>
            </div>
        </div>

        <!-- vector -->
        <div class="ul-footer-vectors">
            <img src="assets/img/footer-vector-img.png" alt="Footer Image" class="ul-footer-vector-1">
        </div>
    </footer>
    <!-- FOOTER SECTION END -->

    <!-- libraries JS -->
    <script src="{{asset('assets/vendor/bootstrap/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/vendor/splide/splide.min.js')}}"></script>
    <script src="{{asset('assets/vendor/splide/splide-extension-auto-scroll.min.js')}}"></script>
    <script src="{{asset('assets/vendor/swiper/swiper-bundle.min.js')}}"></script>
    <script src="{{asset('assets/vendor/slim-select/slimselect.min.js')}}"></script>
    <script src="{{asset('assets/vendor/animate-wow/wow.min.js')}}"></script>
    <script src="{{asset('assets/vendor/splittype/index.min.js')}}"></script>
    <script src="{{asset('assets/vendor/mixitup/mixitup.min.js')}}"></script>
    <script src="{{asset('assets/vendor/fslightbox/fslightbox.js')}}"></script>
    <script src="{{asset('assets/vendor/flatpickr/flatpickr.js')}}"></script>

    <!-- custom JS -->
    <script src="{{asset('assets/js/main.js')}}"></script>
    <script src="{{asset('assets/js/tab.js')}}"></script>
    <!-- <script src="{{asset('assets/js/countdown.js')}}"></script> -->
    <script src="{{asset('assets/js/accordion.js')}}"></script>
    <script src="{{asset('assets/js/progressbar.js')}}"></script>
    <script src="{{asset('assets/js/donate-form.js')}}"></script>
</body>

</html>
