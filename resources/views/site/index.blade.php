@extends('site.layouts.app')
@section('content')

<!-- BANNER SECTION START -->
<section class="ul-banner ul-banner-2">
    <div class="ul-banner-2-slider swiper">
        <div class="swiper-wrapper"> 
            @forelse($banners as $banner)
                <div class="swiper-slide">
                    <div class="ul-banner-2-slide">
                        <!-- bg img -->
                        <img src="{{ Storage::url($banner->background_image) }}"
                             alt="{{ $banner->title }}"
                             class="ul-banner-2-slide-bg-img">

                        <div class="row gy-4 align-items-center">
                            <div class="col-md-7">
                                <div class="ul-banner-txt">
                                    <div class="wow animate__fadeInUp">
                                        @if($banner->subtitle)
                                            <span class="ul-banner-sub-title ul-section-sub-title">{{ $banner->subtitle }}</span>
                                        @endif
                                        @if($banner->title)
                                            <h1 class="ul-banner-title">{{ $banner->title }}</h1>
                                        @endif
                                        @if($banner->paragraph)
                                            <p class="ul-banner-descr">{{ $banner->paragraph }}</p>
                                        @endif
                                        @if($banner->button_text && $banner->button_url)
                                            <div class="ul-banner-btns">
                                                <a href="{{ $banner->button_url }}" class="ul-btn">
                                                    <i class="flaticon-fast-forward-double-right-arrows-symbol"></i>
                                                    {{ $banner->button_text }}
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p>No banners found.</p>
            @endforelse
        </div>
    </div>

    <!-- slider navigation -->
    <div class="ul-banner-2-slider-navigation">
        <button class="prev"><img src="{{ asset('assets/img/left-arrow.png') }}" alt="arrow" width="50px"></button>
        <div class="ul-banner-2-thumb-slider swiper">
            <div class="swiper-wrapper">
                @foreach($banners as $banner)
                    <div class="swiper-slide">
                        <img src="{{ Storage::url($banner->background_image) }}"
                             alt="{{ $banner->title ?? 'Banner Thumb' }}">
                    </div>
                @endforeach
            </div>
        </div>
        <button class="next"><img src="{{ asset('assets/img/right-arrow.png') }}" alt="arrow" width="50px"></button>
    </div>
</section>
<!-- BANNER SECTION END -->




        <!-- FEATURES SECTION START -->
        <section class="ul-features ul-section-spacing">
            <div class="ul-container">
                <div class="row row-cols-xl-4 row-cols-lg-3 row-cols-sm-2 row-cols-1 gy-4 justify-content-center">
                    <!-- single feature -->
                    <div class="col">
                        <div class="ul-feature">
                            <div class="ul-feature-icon">
                                <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g>
                                        <path d="M35.2962 9.02488L18.3509 3.04614C18.1239 2.96598 17.8762 2.96598 17.6491 3.04614L0.703829 9.02488C0.282517 9.17352 0.000563343 9.57149 8.42838e-07 10.0183C-0.000561657 10.465 0.280477 10.8636 0.701438 11.0132L17.6468 17.0374C17.761 17.0781 17.8805 17.0984 18 17.0984C18.1195 17.0984 18.239 17.0781 18.3532 17.0374L35.2986 11.0132C35.7195 10.8636 36.0005 10.465 36 10.0183C35.9994 9.57149 35.7175 9.17352 35.2962 9.02488Z" fill="#EB5310" />
                                        <path d="M33.4668 23.1029V13.9032L31.3574 14.6531V23.1029C30.7221 23.4686 30.2939 24.1538 30.2939 24.9395C30.2939 25.7252 30.7221 26.4105 31.3574 26.7762V31.9593C31.3574 32.5418 31.8296 33.014 32.4121 33.014C32.9946 33.014 33.4668 32.5418 33.4668 31.9593V26.7762C34.1021 26.4106 34.5303 25.7253 34.5303 24.9396C34.5303 24.1538 34.1022 23.4686 33.4668 23.1029Z" fill="#EB5310" />
                                        <path d="M18 19.2078C17.638 19.2078 17.2814 19.1463 16.9402 19.025L7.41406 15.6384V20.2796C7.41406 21.415 8.59862 22.3753 10.9348 23.1335C12.9711 23.7945 15.4803 24.1585 18 24.1585C20.5197 24.1585 23.0289 23.7945 25.0652 23.1335C27.4014 22.3753 28.586 21.415 28.586 20.2796V15.6384L19.0599 19.025C18.7186 19.1463 18.3621 19.2078 18 19.2078Z" fill="#EB5310" />
                                    </g>
                                </svg>
                            </div>
                            <h3 class="ul-feature-title">Education Support</h3>
                        </div>
                    </div>

                    <!-- single feature -->
                    <div class="col">
                        <div class="ul-feature">
                            <div class="ul-feature-icon">
                                <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g>
                                        <path d="M17.99 4.74549C10.1431 -2.11775 0.165878 3.91249 0.00227293 12.0875C-0.0394192 14.1709 0.561988 16.2003 1.75911 18.0712H9.51849L10.8986 15.7709C11.2994 15.1031 12.2692 15.0816 12.6926 15.7474L15.6046 20.3232L19.8492 11.3624C20.2194 10.5806 21.3226 10.5557 21.7308 11.3139L25.3694 18.0712H34.2209C40.7779 7.82326 27.8191 -3.85132 17.99 4.74549Z" fill="#EB5310" />
                                        <path d="M23.8108 19.6258L20.8624 14.1502L16.6931 22.952C16.3384 23.7008 15.2951 23.7658 14.8503 23.0667L11.8292 18.3194L11.0197 19.6684C10.8291 19.9861 10.4859 20.1804 10.1154 20.1804H3.42725C3.6369 20.3998 2.51951 19.2847 17.246 33.9348C17.6573 34.3441 18.3222 34.3442 18.7335 33.9348C33.2334 19.5101 32.343 20.3994 32.5523 20.1804H24.7393C24.3513 20.1805 23.9947 19.9674 23.8108 19.6258Z" fill="#EB5310" />
                                    </g>
                                </svg>
                            </div>
                            <h3 class="ul-feature-title">Healthcare initiatives</h3>
                        </div>
                    </div>

                    <!-- single feature -->
                    <div class="col">
                        <div class="ul-feature">
                            <div class="ul-feature-icon">
                                <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M17.2078 7.34403L20.5198 4.10403L20.1598 3.81603C19.2238 2.95203 17.7838 2.95203 16.9198 3.81603L15.6238 5.11203C15.6238 5.18403 16.1278 5.97603 17.2078 7.34403Z" fill="#FC633B" />
                                    <path d="M30.528 20.088L30.6 20.16L31.896 18.864C32.184 18.576 32.4 18.216 32.472 17.784L29.304 19.296C29.736 19.584 30.168 19.8 30.528 20.088Z" fill="#FC633B" />
                                    <path d="M26.4238 3.60002C26.8558 3.38402 27.2158 3.31202 27.6478 3.31202C28.0798 3.31202 28.5118 3.38402 28.9438 3.60002L27.1438 1.80002C26.2078 0.864022 24.6958 0.864022 23.7598 1.80002L18.0718 7.48802L26.4238 3.60002Z" fill="#FC633B" />
                                    <path d="M34.3438 9.07204L30.3838 5.04004L33.9838 12.744L34.3438 12.384C35.2798 11.52 35.2798 10.008 34.3438 9.07204Z" fill="#FC633B" />
                                    <path d="M29.736 5.40002C29.232 4.24802 27.864 3.81602 26.784 4.32002L18 8.42402C18.432 9.00002 18.864 9.50402 19.368 10.008L25.92 6.91202C26.424 8.06402 27.792 8.56802 28.944 7.99202L31.248 12.888C30.096 13.392 29.592 14.76 30.168 15.912L27 17.424C27.576 17.856 28.08 18.288 28.656 18.72C28.728 18.792 28.728 18.792 28.8 18.792L32.76 16.92C33.912 16.416 34.344 15.048 33.84 13.968L29.736 5.40002Z" fill="#FC633B" />
                                    <path d="M24.5519 13.032C23.9039 11.664 22.6079 11.016 21.5279 11.52C21.3119 11.592 21.0959 11.736 20.9519 11.952C22.1039 13.176 23.3279 14.328 24.6239 15.48C24.9839 14.76 24.9839 13.896 24.5519 13.032Z" fill="#FC633B" />
                                    <path d="M15.0479 5.61603L1.58386 19.152C1.36786 19.368 1.22386 19.584 1.15186 19.8L3.45586 19.512H3.88786C4.82386 19.512 5.68786 19.872 6.33586 20.52L15.2639 29.52C15.9839 30.24 16.3439 31.32 16.2719 32.4L15.9839 34.704C16.1999 34.632 16.4159 34.488 16.6319 34.272L30.1679 20.736C29.5199 20.232 28.8719 19.8 28.2239 19.296C22.9679 15.264 18.5759 10.728 15.0479 5.61603Z" fill="#FC633B" />
                                    <path d="M5.75988 21.024C5.18388 20.448 4.31988 20.16 3.52788 20.232L1.00788 20.592C0.935885 21.168 1.15188 21.744 1.65588 22.248L13.6799 34.272C14.1119 34.704 14.7599 34.92 15.3359 34.92L15.6959 32.4C15.7679 31.536 15.5519 30.744 14.9039 30.168L5.75988 21.024Z" fill="#FC633B" />
                                </svg>
                            </div>
                            <h3 class="ul-feature-title">Livelihood Programs</h3>
                        </div>
                    </div>

                    <!-- single feature -->
                    <div class="col">
                        <div class="ul-feature">
                            <div class="ul-feature-icon">
                                <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M35.0999 16.642C35.0999 20.5527 31.9271 23.6886 28.0533 23.6886H8.79504C4.44164 23.6886 0.899902 20.1469 0.899902 15.7935C0.899902 11.2187 4.81058 7.52937 9.45911 7.8983C10.8242 3.91386 14.6611 1.10999 18.9407 1.10999C23.9951 1.10999 28.164 4.79931 28.865 9.66919C32.3698 10.0381 35.0999 13.0265 35.0999 16.642Z" fill="#FC633B" />
                                    <path d="M8.15492 27.637C10.0519 30.594 10.0519 31.5425 10.0519 31.8493C10.0519 33.5231 8.68495 34.89 7.01117 34.89C5.33739 34.89 3.97046 33.5231 3.97046 31.8493C3.97046 31.5425 3.97046 30.6219 5.86741 27.637C6.09058 27.2464 6.53693 27.0233 6.98326 27.0233C7.45751 27.0233 7.87595 27.2464 8.15492 27.637Z" fill="#FC633B" />
                                    <path d="M19.1437 27.637C21.0406 30.594 21.0406 31.5425 21.0406 31.8493C21.0406 33.5231 19.6737 34.89 17.9999 34.89C16.3262 34.89 14.9592 33.5231 14.9592 31.8493C14.9592 31.5425 14.9592 30.6219 16.8562 27.637C17.0793 27.2464 17.5257 27.0233 17.972 27.0233C18.4463 27.0233 18.8647 27.2464 19.1437 27.637Z" fill="#FC633B" />
                                    <path d="M30.1325 27.637C32.0294 30.594 32.0294 31.5425 32.0294 31.8493C32.0294 33.5231 30.6625 34.89 28.9887 34.89C27.3149 34.89 25.948 33.5231 25.948 31.8493C25.948 31.5425 25.948 30.6219 27.8449 27.637C28.0681 27.2464 28.5145 27.0233 28.9608 27.0233C29.435 27.0233 29.8535 27.2464 30.1325 27.637Z" fill="#FC633B" />
                                </svg>
                            </div>
                            <h3 class="ul-feature-title">Access to Water</h3>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- FEATURES SECTION END -->


        <!-- VOLUNTEER SECTION START -->
        <section class="ul-volunteer">
            <div class="row row-cols-md-2 row-cols-1 g-0">
                <!-- volunteer block -->
                <div class="col">
                    <div class="ul-volunteer-block">
                        <h2 class="ul-volunteer-title">Become A Member</h2>
                        <p class="ul-volunteer-descr">Join as an individual, group, or family to make a difference. Donate and receive support on your terms, while helping those in need around the world.</p>
                        <ul class="ul-volunteer-list">
                            <li>Donate Money to Support Others</li>
                            <li>Receive Donations for Your Needs</li>
                            <li>Manage Donations with Care and Transparency</li>
                        </ul>
                        <a href="/register" class="ul-btn"><i class="flaticon-fast-forward-double-right-arrows-symbol"></i> Become A Member</a>
                    </div>
                </div>


                <!-- donate form -->
                <div class="col">
                    <div class="ul-volunteer-block ul-donate-form-wrapper-2">
                        <h2 class="ul-volunteer-title">Support a Family in Need</h2>
                        <p class="ul-volunteer-descr">Your donation helps the families of those who have passed away. By contributing, you offer financial support to help cover immediate needs, funeral costs, and other essential expenses during their time of loss.</p>
                        <form action="{{ route('donation.checkout') }}" method="POST" class="ul-donate-form ul-donate-form-2">
                            @csrf
                            <input type="hidden" name="donation_type" value="general">
                            <div>
                                <input type="radio" name="amount" id="donate-amount-1" value="10" checked hidden>
                                <label for="donate-amount-1" class="ul-donate-form-label">$10</label>
                            </div>

                            <div>
                                <input type="radio" name="amount" id="donate-amount-2" value="20" hidden>
                                <label for="donate-amount-2" class="ul-donate-form-label">$20</label>
                            </div>

                            <div>
                                <input type="radio" name="amount" id="donate-amount-3" value="30" hidden>
                                <label for="donate-amount-3" class="ul-donate-form-label">$30</label>
                            </div>

                            <div>
                                <input type="radio" name="amount" id="donate-amount-4" value="40" hidden>
                                <label for="donate-amount-4" class="ul-donate-form-label">$40</label>
                            </div>

                            <div>
                                <input type="radio" name="amount" id="donate-amount-5" value="50" hidden>
                                <label for="donate-amount-5" class="ul-donate-form-label">$50</label>
                            </div>

                            <div class="custom-amount-wrapper">
                                <input type="radio" name="amount" id="custom-amount" value="">
                                <label for="donate-amount-custom" class="ul-donate-form-label">
                                    <input type="number" name="custom_amount" id="donate-amount-custom" placeholder="Custom Amount" class="ul-donate-form-custom-input">
                                </label>
                            </div>

                            <div>
                                <button type="submit" class="ul-btn"><i class="flaticon-fast-forward-double-right-arrows-symbol"></i> Continue to Checkout</button>
                            </div>
                        </form>
                    </div>
                </div> 
            </div>
        </section>
        <!-- VOLUNTEER SECTION END -->


        <!-- ABOUT SECTION START -->
        <section class="ul-about ul-about-2 ul-section-spacing wow animate__fadeInUp">
            <div class="ul-container">
                <div class="row row-cols-md-2 row-cols-1 align-items-center gy-4 ul-about-row">
                    <div class="col">
                        <div class="ul-about-imgs ul-about-2-img">
                            <div class="img-wrapper">
                                <img src="{{asset('assets/img/home/about-us.jpg')}}" alt="Image">
                            </div>

                            <div class="ul-about-2-stat">
                                <span class="number">15+</span>
                                <span class="txt">Years Of Experience</span>
                            </div>
                        </div>
                    </div>

                    <!-- txt -->
                    <div class="col">
                        @php
                            $about = get_static('home', 'about-section');
                        @endphp
                        <div class="ul-about-txt">
                            <span class="ul-section-sub-title ul-section-sub-title--2">{{ $about['title'] }}</span>
                            <h2 class="ul-section-title">{{ $about['subtitle'] }}</h2>
                            <p class="ul-section-descr">{{ $about['description'] }}</p>

                            <div class="ul-about-bottom ul-about-2-bottom">
                                <div class="ul-about-2-bottom-block">
                                    <div class="ul-about-2-bottom-block-icon">
                                        <i class="{{ $about['block']['left']['icon'] }}"></i>
                                    </div>
                                    <div class="ul-about-2-bottom-block-txt">
                                        <h3 class="ul-about-2-bottom-block-title">{{ $about['block']['left']['title'] }}</h3>
                                        @foreach($about['block']['left']['list'] as $item)
                                            <p class="ul-about-2-bottom-block-descr">{{ $item }}</p>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <a href="{{ $about['button']['url'] }}" class="ul-btn"><i class="flaticon-fast-forward-double-right-arrows-symbol"></i> {{ $about['button']['text'] }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ABOUT SECTION END -->


        <!-- SERVICES SECTION START -->
        <section class="ul-services ul-section-spacing overflow-hidden">
            <div class="ul-container">
                <div class="ul-section-heading">
                    <div>
                        <span class="ul-section-sub-title">Together, We Can Change Lives Forever.</span>
                        <h2 class="ul-section-title">Recent Donation Opportunities</h2>
                    </div>

                    <div class="ul-services-slider-nav ul-slider-nav position-static">
                        <button class="prev"><i class="flaticon-back"></i></button>
                        <button class="next"><i class="flaticon-next"></i></button>
                    </div>
                </div>

                <div class="ul-services-slider swiper overflow-visible">
                    <div class="swiper-wrapper">
                        @foreach($incidents as $incident)
                        <!-- single slide -->
                        <div class="swiper-slide">
                            <div class="ul-service">
                                <div class="ul-service-img">
                                    @if(isset($incident['thumbnail_path']) && $incident['thumbnail_path'])
                                        <img src="{{ Storage::url($incident['thumbnail_path']) }}" alt="{{ $incident['deceased_name'] }}">
                                    @endif
                                </div>
                                <div class="ul-service-txt">
                                    <h3 class="ul-service-title"><a href="{{ route('donation.detail', ['incident' => $incident->id]) }}">{{ $incident->deceased_name }}</a></h3>
                                    <p class="ul-service-descr">{{ Str::limit($incident->description, 100) }}</p>
                                    <div class="ul-donation-progress">
                                        <div class="donation-progress-container ul-progress-container">
                                            <div class="donation-progressbar ul-progressbar" data-ul-progress-value="{{ ($incident->amount / 100) }}">
                                                <div class="donation-progress-label ul-progress-label"></div>
                                            </div>
                                        </div>
                                        <div class="ul-donation-progress-labels">
                                            <span class="ul-donation-progress-label">Raised : ${{ number_format($incident->amount, 2) }}</span>
                                            <span class="ul-donation-progress-label">Goal : ${{ number_format($incident->amount * 1.2, 2) }}</span>
                                        </div>
                                    </div>
                                    <a href="{{ route('donation.detail', ['incident' => $incident->id]) }}" class="ul-service-btn"><i class="flaticon-up-right-arrow"></i> Donate Now</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        <!-- SERVICES SECTION END -->


        <!-- GALLERY PREVIEW SECTION START -->
        <section class="ul-projects ul-section-spacing">
            <div class="ul-container">
                <div class="ul-section-heading text-center justify-content-center">
                    <div>
                        <span class="ul-section-sub-title">Gallery</span>
                        <h2 class="ul-section-title">Our Latest Gallery Images</h2>
                    </div>
                </div>
                @php
                    $galleryPreview = \App\Models\Gallery::latest()->take(6)->get();
                @endphp
                <div class="row ul-bs-row justify-content-center">
                    @foreach($galleryPreview as $gallery)
                        <div class="col-lg-4 col-md-6 col-10 col-xxs-12">
                            <div class="ul-project ul-project--sm">
                                <div class="ul-project-img">
                                    <a href="{{ Storage::url($gallery->image_path) }}" data-lightbox="gallery-preview" data-title="{{ $gallery->title }}">
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
                <div class="text-center mt-4">
                    <a href="{{ route('gallery') }}" class="ul-btn"><i class="flaticon-fast-forward-double-right-arrows-symbol"></i> View Full Gallery</a>
                </div>
            </div>
        </section>
        <!-- GALLERY PREVIEW SECTION END -->
        <!-- Simple Lightbox JS (CDN) for preview -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/simplelightbox/2.14.1/simple-lightbox.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/simplelightbox/2.14.1/simple-lightbox.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                new SimpleLightbox('[data-lightbox="gallery-preview"]', {});
            });
        </script>


        <!-- CTA(CALL TO ACTION) SECTION START -->
        <section class="ul-cta">
            <div class="ul-container">
                <span class="ul-section-sub-title">Start Donating Poor People</span>
                <h2 class="ul-cta-title">Families Need Your Help By Donating Today</h2>
                <a href="{{ route('donation') }}" class="ul-btn"><i class="flaticon-fast-forward-double-right-arrows-symbol"></i> Donate Now</a>
            </div>
            <img src="assets/img/cta-vector.svg" alt="Vector" class="ul-cta-vector">
        </section>
        <!-- CTA(CALL TO ACTION) SECTION END -->


        <!-- TESTIMONIAL SECTION START -->
        <section class="ul-testimonial-2 ul-section-spacing">
            <div class="ul-container wow animate__fadeInUp">
                <div class="ul-section-heading">
                    <div>
                        <span class="ul-section-sub-title">Start donating poor people</span>
                        <h2 class="ul-section-title">What People Say About us</h2>
                    </div>
                    <!-- <a href="#" class="ul-btn"><i class="flaticon-fast-forward-double-right-arrows-symbol"></i> All Testimonials</a> -->
                </div>

                @php
                    $testimonials = get_static('home', 'testimonials');
                @endphp
                <div class="row ul-testimonial-2-row gy-4">
                    <!-- card -->
                    <div class="col-md-4">
                        <div class="ul-testimonial-2-overview">
                            <span class="rating">{{ $testimonials['overview']['rating'] }}</span>
                            <div class="ul-testimonial-2-overview-stars">
                                @for($i = 0; $i < $testimonials['overview']['stars']; $i++)
                                    <i class="flaticon-star"></i>
                                @endfor
                            </div>
                            <span class="ul-testimonial-2-overview-title">{{ $testimonials['overview']['title'] }}</span>
                            <p class="ul-testimonial-2-overview-descr">{{ $testimonials['overview']['description'] }}</p>
                        </div>
                    </div>

                    <!-- txt -->
                    <div class="col-md-8">
                        <div class="ul-testimonial-2-slider swiper">
                            <div class="swiper-wrapper">
                                @foreach($testimonials['reviews'] as $review)
                                <!-- single slide -->
                                <div class="swiper-slide">
                                    <div class="ul-review ul-review-2">
                                        <span class="icon"><i class="flaticon-quote-1"></i></span>
                                        <p class="ul-review-descr">{{ $review['text'] }}</p>
                                        <div class="ul-review-bottom">
                                            <div class="ul-review-reviewer">
                                                <div>
                                                    <h3 class="reviewer-name">{{ $review['reviewer']['name'] }}</h3>
                                                    <span class="reviewer-role">{{ $review['reviewer']['role'] }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <div class="ul-testimonial-2-slider-nav">
                                <button class="prev"><i class="flaticon-back"></i></button>
                                <button class="next"><i class="flaticon-next"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

            <!-- CONTACT SECTION START -->
            <section class="ul-contact">
                <div class="ul-container">
                    <div class="row g-0">
                        <div class="col-lg-5">
                            <div class="ul-contact-img">
                                <img src="{{asset('assets/img/home/contact-us.jpg')}}" alt="Image">
                            </div>
                        </div>

                        <!-- form -->
                        <div class="col-lg-7 d-flex align-items-center justify-content-center" style="background-color: #0078b8;">
                            <div class="ul-contact-form-wrapper" style="height: auto;">
                                <span class="ul-section-sub-title">Contact us</span>
                                <h2 class="ul-section-title">Send Us Message For Donation</h2>

                                <form action="{{ route('contact.store') }}" method="POST" class="ul-contact-form ul-form">
                                    @csrf
                                    <div class="row row-cols-2 row-cols-xxs-1 ul-bs-row">
                                        <div class="col">
                                            <div class="form-group">
                                                <input type="text"
                                                    name="name"
                                                    id="ul-contact-name"
                                                    placeholder="Your Name"
                                                    value="{{ old('name') }}"
                                                    class="form-control @error('name') is-invalid @enderror">
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <input type="email"
                                                    name="email"
                                                    id="ul-contact-email"
                                                    placeholder="Email Address"
                                                    value="{{ old('email') }}"
                                                    class="form-control @error('email') is-invalid @enderror">
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <input type="text"
                                                    name="subject"
                                                    id="ul-contact-subject"
                                                    placeholder="Subject"
                                                    value="{{ old('subject') }}"
                                                    class="form-control @error('subject') is-invalid @enderror">
                                                @error('subject')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <textarea name="message"
                                                        id="ul-contact-msg"
                                                        placeholder="Type your message"
                                                            class="form-control @error('message') is-invalid @enderror"
                                                        rows="6">{{ old('message') }}</textarea>
                                                @error('message')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 text-center">
                                            <button type="submit" class="ul-btn">
                                                <i class="flaticon-fast-forward-double-right-arrows-symbol"></i> Get in Touch
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- CONTACT SECTION END -->

        <!-- BLOG SECTION START -->
        <section class="ul-blogs-2 ul-section-spacing">
            <div class="ul-container wow animate__fadeInUp">
                <div class="ul-section-heading">
                    <div class="left">
                        <span class="ul-section-sub-title"> Latest Blog </span>
                        <h2 class="ul-section-title">Read Our Latest News</h2>
                    </div>

                    <a href="blog.html" class="ul-btn"><i class="flaticon-fast-forward-double-right-arrows-symbol"></i> All Blogs</a>
                </div>

                <div class="row row-cols-md-3 row-cols-2 row-cols-xxs-1 ul-bs-row justify-content-center">
                    @foreach($recentBlogs as $blog)
                    <!-- single blog -->
                    <div class="col">
                        <div class="ul-blog ul-blog-2">
                            <div class="ul-blog-img">
                                <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}">
                                <div class="date">
                                    <span class="number">{{ $blog->created_at->format('d') }}</span>
                                    <span class="txt">{{ $blog->created_at->format('M') }}</span>
                                </div>
                            </div>
                            <div class="ul-blog-txt">
                                <div class="ul-blog-infos">
                                    <!-- single info -->
                                    <div class="ul-blog-info">
                                        <span class="icon"><i class="flaticon-account"></i></span>
                                        <span class="text font-normal text-[14px] text-etGray">By {{ $blog->author->name }}</span>
                                    </div>
                                    <!-- single info -->
                                    <div class="ul-blog-info">
                                        <span class="icon"><i class="flaticon-price-tag"></i></span>
                                        <span class="text font-normal text-[14px] text-etGray">
                                            @foreach($blog->categories as $category)
                                                {{ $category->name }}@if(!$loop->last), @endif
                                            @endforeach
                                        </span>
                                    </div>
                                </div>
                                <a href="{{ route('blog.detail', ['blog' => $blog->slug]) }}" class="ul-blog-title">{{ $blog->title }}</a>
                                <a href="{{ route('blog.detail', ['blog' => $blog->slug]) }}" class="ul-blog-btn">Read More <span class="icon"><i class="flaticon-next"></i></span></a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
@endsection

