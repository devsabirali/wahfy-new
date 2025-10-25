@extends('site.layouts.app')
@section('content')
    <!-- HEADER SECTION START -->
    <header class="ul-header">
        <div class="ul-header-bottom to-be-sticky">
            <div class="ul-header-bottom-wrapper ul-header-container">
                <div class="logo-container">
                    <a href="index.html" class="d-inline-block"><img src="assets/img/logo.svg" alt="logo" class="logo"></a>
                </div>

                <!-- header nav -->
                <div class="ul-header-nav-wrapper">
                    <div class="to-go-to-sidebar-in-mobile">
                        <nav class="ul-header-nav">
                            <div class="has-sub-menu">
                                <a role="button">Home</a>

                                <div class="ul-header-submenu">
                                    <ul>
                                        <li><a href="index.html">Home 1</a></li>
                                        <li><a href="index-2.html">Home 2</a></li>
                                    </ul>
                                </div>
                            </div>
                            <a href="about.html">About</a>
                            <div class="has-sub-menu">
                                <a role="button">Pages</a>

                                <div class="ul-header-submenu">
                                    <ul>
                                        <li><a href="services.html">Services</a></li>
                                        <li><a href="service-details.html">Service Details</a></li>
                                        <li><a href="projects.html">Projects</a></li>
                                        <li><a href="project-details.html">Project Details</a></li>
                                        <li><a href="team.html">Team</a></li>
                                        <li><a href="team-details.html">Team Member Details</a></li>
                                        <li><a href="pricing.html">Pricing Plans</a></li>
                                        <li><a href="faq.html">FAQs</a></li>
                                        <li><a href="404.html">404</a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="has-sub-menu">
                                <a role="button">Donation</a>

                                <div class="ul-header-submenu">
                                    <ul>
                                        <li><a href="donations.html">Donation Listing</a></li>
                                        <li><a href="donation-details.html">Donation Details</a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="has-sub-menu">
                                <a role="button">Event</a>

                                <div class="ul-header-submenu">
                                    <ul>
                                        <li><a href="events.html">Events</a></li>
                                        <li><a href="event-details.html">Event Details</a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="has-sub-menu">
                                <a role="button">Blog</a>

                                <div class="ul-header-submenu">
                                    <ul>
                                        <li><a href="blog.html">Blogs</a></li>
                                        <li><a href="blog-2.html">Blogs Layout 2</a></li>
                                        <li><a href="blog-details.html">Blog Details</a></li>
                                    </ul>
                                </div>
                            </div>
                            <a href="contact.html">Contact</a>
                        </nav>
                    </div>
                </div>

                <!-- actions -->
                <div class="ul-header-actions">
                    <button class="ul-header-search-opener"><i class="flaticon-search"></i></button>
                    <a href="contact.html" class="ul-btn d-sm-inline-flex d-none"><i class="flaticon-fast-forward-double-right-arrows-symbol"></i> Join With us </a>
                    <button class="ul-header-sidebar-opener d-lg-none d-inline-flex"><i class="flaticon-menu"></i></button>
                </div>
            </div>
        </div>
    </header>
    <!-- HEADER SECTION END -->


    <main>
        <!-- BREADCRUMBS SECTION START -->
        @include('site.layouts.breadcrumbs', [
            'title' => 'Projects',
            'items' => [
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'Projects']
            ]
        ])
        <!-- BREADCRUMBS SECTION END -->


        <!-- PROJECTS SECTION START -->
        <section class="ul-projects ul-section-spacing">
            <div class="ul-container">
                <div class="row ul-bs-row justify-content-center">
                    <div class="col-lg-8 col-md-6 col-10 col-xxs-12">
                        <div class="ul-project ">
                            <div class="ul-project-img">
                                <img src="assets/img/project-1.jpg" alt="Project Image">
                            </div>
                            <div class="ul-project-txt">
                                <div>
                                    <h3 class="ul-project-title"><a href="project-details.html">Child trouble & care</a></h3>
                                    <p class="ul-project-descr"> Demostic & Transportation</p>
                                </div>
                                <a href="project-details.html" class="ul-project-btn"><i class="flaticon-up-right-arrow"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-10 col-xxs-12">
                        <div class="ul-project ul-project--sm">
                            <div class="ul-project-img">
                                <img src="assets/img/project-2.jpg" alt="Project Image">
                            </div>
                            <div class="ul-project-txt">
                                <div>
                                    <h3 class="ul-project-title"><a href="project-details.html">Child trouble & care</a></h3>
                                    <p class="ul-project-descr"> Demostic & Transportation</p>
                                </div>
                                <a href="project-details.html" class="ul-project-btn"><i class="flaticon-up-right-arrow"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-10 col-xxs-12">
                        <div class="ul-project ul-project--sm">
                            <div class="ul-project-img">
                                <img src="assets/img/project-3.jpg" alt="Project Image">
                            </div>
                            <div class="ul-project-txt">
                                <div>
                                    <h3 class="ul-project-title"><a href="project-details.html">Child trouble & care</a></h3>
                                    <p class="ul-project-descr"> Demostic & Transportation</p>
                                </div>
                                <a href="project-details.html" class="ul-project-btn"><i class="flaticon-up-right-arrow"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8 col-md-6 col-10 col-xxs-12">
                        <div class="ul-project ">
                            <div class="ul-project-img">
                                <img src="assets/img/project-4.jpg" alt="Project Image">
                            </div>
                            <div class="ul-project-txt">
                                <div>
                                    <h3 class="ul-project-title"><a href="project-details.html">Child trouble & care</a></h3>
                                    <p class="ul-project-descr"> Demostic & Transportation</p>
                                </div>
                                <a href="project-details.html" class="ul-project-btn"><i class="flaticon-up-right-arrow"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8 col-md-6 col-10 col-xxs-12">
                        <div class="ul-project ">
                            <div class="ul-project-img">
                                <img src="assets/img/project-1.jpg" alt="Project Image">
                            </div>
                            <div class="ul-project-txt">
                                <div>
                                    <h3 class="ul-project-title"><a href="project-details.html">Child trouble & care</a></h3>
                                    <p class="ul-project-descr"> Demostic & Transportation</p>
                                </div>
                                <a href="project-details.html" class="ul-project-btn"><i class="flaticon-up-right-arrow"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-10 col-xxs-12">
                        <div class="ul-project ul-project--sm">
                            <div class="ul-project-img">
                                <img src="assets/img/project-2.jpg" alt="Project Image">
                            </div>
                            <div class="ul-project-txt">
                                <div>
                                    <h3 class="ul-project-title"><a href="project-details.html">Child trouble & care</a></h3>
                                    <p class="ul-project-descr"> Demostic & Transportation</p>
                                </div>
                                <a href="project-details.html" class="ul-project-btn"><i class="flaticon-up-right-arrow"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- PROJECTS SECTION END -->
  @endsection
