@extends('site.layouts.app')
@section('content')
        <!-- BREADCRUMBS SECTION START -->
        @include('site.layouts.breadcrumbs', [
            'title' => 'Events',
            'items' => [
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'Events']
            ]
        ])
        <!-- BREADCRUMBS SECTION END -->


        <!-- EVENTS SECTION START -->
        <section class="ul-section-spacing">
            <div class="ul-container">
                <!-- events -->
                <div class="ul-events-wrapper">
                    <div class="row ul-bs-row row-cols-lg-2 row-cols-1">
                        <!-- single event -->
                        <div class="col wow animate__fadeInUp">
                            <div class="ul-event ul-event--inner">
                                <div class="ul-event-img">
                                    <img src="assets/img/event-img.jpg" alt="Event Image">
                                    <span class="date">29 <span>July</span></span>
                                </div>
                                <div class="ul-event-txt">
                                    <h3 class="ul-event-title"><a href="event-details.html">Manager Disapproved of the Most Recent Work.</a></h3>
                                    <p class="ul-event-descr">Dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernaturaut</p>
                                    <div class="ul-event-info">
                                        <span class="ul-event-info-title">Venue</span>
                                        <p class="ul-event-info-descr">350 5th AveNew York, NY 118 United States</p>
                                    </div>
                                    <a href="event-details.html" class="ul-btn"><i class="flaticon-fast-forward-double-right-arrows-symbol"></i> Event Details</a>
                                </div>
                            </div>
                        </div>

                        <!-- single event -->
                        <div class="col wow animate__fadeInUp">
                            <div class="ul-event ul-event--inner">
                                <div class="ul-event-img">
                                    <img src="assets/img/blog-b-1.jpg" alt="Event Image">
                                    <span class="date">29 <span>July</span></span>
                                </div>
                                <div class="ul-event-txt">
                                    <h3 class="ul-event-title"><a href="event-details.html">Manager Disapproved of the Most Recent Work.</a></h3>
                                    <p class="ul-event-descr">Dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernaturaut</p>
                                    <div class="ul-event-info">
                                        <span class="ul-event-info-title">Venue</span>
                                        <p class="ul-event-info-descr">350 5th AveNew York, NY 118 United States</p>
                                    </div>
                                    <a href="event-details.html" class="ul-btn"><i class="flaticon-fast-forward-double-right-arrows-symbol"></i> Event Details</a>
                                </div>
                            </div>
                        </div>

                        <!-- single event -->
                        <div class="col wow animate__fadeInUp">
                            <div class="ul-event ul-event--inner">
                                <div class="ul-event-img">
                                    <img src="assets/img/blog-b-2.jpg" alt="Event Image">
                                    <span class="date">29 <span>July</span></span>
                                </div>
                                <div class="ul-event-txt">
                                    <h3 class="ul-event-title"><a href="event-details.html">Manager Disapproved of the Most Recent Work.</a></h3>
                                    <p class="ul-event-descr">Dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernaturaut</p>
                                    <div class="ul-event-info">
                                        <span class="ul-event-info-title">Venue</span>
                                        <p class="ul-event-info-descr">350 5th AveNew York, NY 118 United States</p>
                                    </div>
                                    <a href="event-details.html" class="ul-btn"><i class="flaticon-fast-forward-double-right-arrows-symbol"></i> Event Details</a>
                                </div>
                            </div>
                        </div>

                        <!-- single event -->
                        <div class="col wow animate__fadeInUp">
                            <div class="ul-event ul-event--inner">
                                <div class="ul-event-img">
                                    <img src="assets/img/blog-3.jpg" alt="Event Image">
                                    <span class="date">29 <span>July</span></span>
                                </div>
                                <div class="ul-event-txt">
                                    <h3 class="ul-event-title"><a href="event-details.html">Manager Disapproved of the Most Recent Work.</a></h3>
                                    <p class="ul-event-descr">Dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernaturaut</p>
                                    <div class="ul-event-info">
                                        <span class="ul-event-info-title">Venue</span>
                                        <p class="ul-event-info-descr">350 5th AveNew York, NY 118 United States</p>
                                    </div>
                                    <a href="event-details.html" class="ul-btn"><i class="flaticon-fast-forward-double-right-arrows-symbol"></i> Event Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ul-pagination">
                <ul>
                    <li><a href="#"><i class="flaticon-back"></i></a></li>
                    <li class="pages">
                        <a href="#" class="active">1</a>
                        <a href="#">2</a>
                        <a href="#">3</a>
                    </li>
                    <li><a href="#"><i class="flaticon-next"></i></a></li>
                </ul>
            </div>
        </section>
        <!-- EVENTS SECTION END -->
   @endsection
