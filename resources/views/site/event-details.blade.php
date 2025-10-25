@extends('site.layouts.app')
@section('content')
        <!-- BREADCRUMBS SECTION START -->
        @include('site.layouts.breadcrumbs', [
            'title' => 'Event Details',
            'items' => [
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'Events', 'url' => route('events')],
                ['label' => 'Event Details']
            ]
        ])
        <!-- BREADCRUMBS SECTION END -->


        <div class="ul-container ul-section-spacing">
            <div class="row gx-0 gy-4 flex-column-reverse flex-lg-row">
                <!-- left sidebar -->
                <div class="col-lg-4">
                    <div class="ul-inner-sidebar">
                        <!-- single widget /search -->
                        <div class="ul-inner-sidebar-widget ul-inner-sidebar-search">
                            <h3 class="ul-inner-sidebar-widget-title">Search</h3>
                            <div class="ul-inner-sidebar-widget-content">
                                <form action="#" class="ul-blog-search-form">
                                    <input type="search" name="blog-search" id="ul-blog-search" placeholder="Search Here">
                                    <button type="submit"><span class="icon"><i class="flaticon-search"></i></span></button>
                                </form>
                            </div>
                        </div>

                        <!-- single widget / Categories -->
                        <div class="ul-inner-sidebar-widget categories">
                            <h3 class="ul-inner-sidebar-widget-title">Categories</h3>
                            <div class="ul-inner-sidebar-widget-content">
                                <div class="ul-inner-sidebar-categories">
                                    <a href="donations.html">Charity <span>(08)</span></a>
                                    <a href="donations.html">Crowdfunding <span>(11)</span></a>
                                    <a href="donations.html">Industries <span>(18)</span></a>
                                    <a href="donations.html">Innovations <span>(11)</span></a>
                                    <a href="donations.html">Technology <span>(07)</span></a>
                                </div>
                            </div>
                        </div>

                        <!-- single widget / Recent Posts -->
                        <div class="ul-inner-sidebar-widget posts">
                            <h3 class="ul-inner-sidebar-widget-title">Recent Posts</h3>
                            <div class="ul-inner-sidebar-widget-content">
                                <div class="ul-inner-sidebar-posts">
                                    <!-- single post -->
                                    <div class="ul-inner-sidebar-post">
                                        <div class="img">
                                            <img src="assets/img/blog-2.jpg" alt="Post Image">
                                        </div>

                                        <div class="txt">
                                            <h4 class="title"><a href="blog-details.html">There are many vario ns of passages of</a></h4>
                                            <span class="date"> <span>May 12, 2025</span></span>
                                        </div>
                                    </div>

                                    <!-- single post -->
                                    <div class="ul-inner-sidebar-post">
                                        <div class="img">
                                            <img src="assets/img/blog-1.jpg" alt="Post Image">
                                        </div>

                                        <div class="txt">
                                            <h4 class="title"><a href="blog-details.html">There are many vario ns of passages of</a></h4>
                                            <span class="date"> <span>May 12, 2025</span></span>
                                        </div>
                                    </div>

                                    <!-- single post -->
                                    <div class="ul-inner-sidebar-post">
                                        <div class="img">
                                            <img src="assets/img/blog-3.jpg" alt="Post Image">
                                        </div>

                                        <div class="txt">
                                            <h4 class="title"><a href="blog-details.html">There are many vario ns of passages of</a></h4>
                                            <span class="date"> <span>May 12, 2025</span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- single widget / Tags -->
                        <div class="ul-inner-sidebar-widget tags">
                            <h3 class="ul-inner-sidebar-widget-title">Tag Cloud</h3>
                            <div class="ul-inner-sidebar-widget-content">
                                <div class="ul-inner-sidebar-tags">
                                    <a href="donations.html">Crowdfunding</a>
                                    <a href="donations.html">Innovations</a>
                                    <a href="donations.html">Justice</a>
                                    <a href="donations.html">Lead</a>
                                    <a href="donations.html">Startup</a>
                                    <a href="donations.html">Technology</a>
                                    <a href="donations.html">Market</a>
                                    <a href="donations.html">Court</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- event details content -->
                <div class="col-lg-8">
                    <div class="ul-event-details ul-donation-details">
                        <div class="ul-event-details-img">
                            <img src="assets/img/event-details.jpg" alt="Image">
                        </div>
                        <div class="ul-event-details-infos">
                            <!-- single info -->
                            <div class="ul-event-details-info">
                                <span class="icon"><i class="flaticon-account"></i></span>
                                <span class="text">By Admin</span>
                            </div>
                            <!-- single info -->
                            <div class="ul-event-details-info">
                                <span class="icon"><i class="flaticon-price-tag"></i></span>
                                <span class="text">Donation</span>
                            </div>
                        </div>
                        <h2 class="ul-event-details-title">Manager Disapproved of the Most Recent Work.</h2>
                        <p class="ul-event-details-descr">I must explain to you how all this mistaken idea of pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful.</p>
                        <p>Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise.</p>
                        <h3 class="ul-event-details-inner-title">Our Event Mission</h3>
                        <p class="ul-event-details-descr">Cast obscure badger jeep quail congenialy when changed as cat jeepers affectionate thus facilisi goodness this far like ipsum dolor sit amet, consectetur adipisicing elits eiusmod tempo incididunt et laboret dolore magna aliqua enim ad minim. Eveniet in vulputate esse molestie consequat, illum Eveniet in vulputate esse molestie dolore .</p>
                        <ul class="ul-event-details-list">
                            <li>Creating and editing content</li>
                            <li>Workflows, reporting, and content organization</li>
                            <li>User & role-based administration and security</li>
                            <li>Flexibility, scalability, and performance and analysis</li>
                            <li>Multilingual content capabilities</li>
                        </ul>
                        <h3 class="ul-event-inner-title">See Our Locations</h3>
                        <div class="ul-event-details-map">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6138.2324980070525!2d90.43028998193272!3d23.825180986890324!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c63855fb64f1%3A0xb613b7b7edbcab99!2sBlock%20G%2C%20Dhaka!5e0!3m2!1sen!2sbd!4v1736745125068!5m2!1sen!2sbd" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>

                        <h3 class="ul-event-inner-title">Contact us</h3>
                        <p>Your email address will not be published. Required fields are marked *</p>
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
                                <div class="col">
                                    <div class="form-group">
                                        <input type="tel" name="phone" id="ul-contact-phone" placeholder="Phone Number">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <input type="text" name="subject" id="ul-contact-subject" placeholder="Subject">
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
   @endsection
