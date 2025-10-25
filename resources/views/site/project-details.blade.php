@extends('site.layouts.app')
@section('content')
        <!-- BREADCRUMBS SECTION START -->
        @include('site.layouts.breadcrumbs', [
            'title' => 'Project Details',
            'items' => [
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'Projects', 'url' => route('projects')],
                ['label' => 'Project Details']
            ]
        ])
        <!-- BREADCRUMBS SECTION END -->


        <div class="ul-container ul-section-spacing">
            <div class="ul-project-details-img-slider swiper">
                <div class="swiper-wrapper">
                    <!-- single slide -->
                    <div class="swiper-slide">
                        <div>
                            <img src="assets/img/project-details-img-1.jpg" alt="Image">
                        </div>
                    </div>
                    <!-- single slide -->
                    <div class="swiper-slide">
                        <div>
                            <img src="assets/img/project-details-img-1.jpg" alt="Image">
                        </div>
                    </div>
                    <!-- single slide -->
                    <div class="swiper-slide">
                        <div>
                            <img src="assets/img/project-details-img-1.jpg" alt="Image">
                        </div>
                    </div>
                </div>

                <div class="ul-project-details-slider-nav ul-slider-nav">
                    <button class="prev"><i class="flaticon-back"></i></button>
                    <button class="next"><i class="flaticon-next"></i></button>
                </div>
            </div>

            <div class="row gx-5 gy-4 flex-column-reverse flex-lg-row">
                <!-- event details content -->
                <div class="col-md-8">
                    <div class="ul-event-details">
                        <h2 class="ul-event-details-title">Child trouble & care</h2>
                        <p class="ul-event-details-descr">Netus lorem rutrum arcu dignissim at sit morbi phasellus nascetur eget potenti vestibulum is cras. Tempor nonummy metus lobortis. Sociis velit etiam, dapibus.Lectus ve pellentesque a cras posuere tempor facilisi habitant lectus rutrum pede quisque hendrerit mauris ad to elementum fringilla facilisi volutpat fusce pharetra.</p>
                        <p>Netus lorem rutrum arcu dignissim at sit morbi phasellus nascetur eget potenti vestibulum is cras. Tempor nonummy metus lobortis. Sociis velit etiam, dapibus.Lectus ve pellentesque a cras posuere tempor facilisi habitant lectus rutrum pede . Netus lorem rutrum arcu dignissim at sit morbi phasellus nascetur eget potenti vestibulum is cras.</p>
                        <h3 class="ul-event-details-inner-title">Challenge & Solution </h3>
                        <p class="ul-event-details-descr">Future, as it seeks to lead the industry in technological innovation and sustainable building practices to deliver long-lasting value for its clients. Netus lorem rutrum arcu dignissim at sit morbi nascetur eget potenti vestibulum is cras. Tempor nonummy metus lobortis. Sociis velit etiam, dapibus.Lepellentesque a cras posuere tempor facilisi habitant lectus rutrum pede .</p>

                        <h3 class="ul-event-inner-title">Final Result</h3>
                        <p>For almost 50 years Leighton Asia, one of the region's largest and most respected construc companies, has been progressively building for a better future by leveraging international expertise with local intelligence. In that time Leighton./p>
                    </div>
                </div>

                <!-- sidebar -->
                <div class="col-md-4">
                    <div class="ul-project-details-infos">
                        <h4 class="ul-project-details-infos-title">Project Information</h4>
                        <ul class="ul-project-details-infos-list">
                            <li><span class="key">CATEGORY</span>:<span class="value">Business, Marketing</span></li>
                            <li><span class="key">AUTHOR</span>:<span class="value">Athena Jones</span></li>
                            <li><span class="key">TAGS</span>:<span class="value">Data Masters</span></li>
                            <li><span class="key">COST</span>:<span class="value">USD 1,50,499</span></li>
                            <li><span class="key">DATE</span>:<span class="value">25 February, 2024</span></li>
                        </ul>

                        <div class="ul-footer-socials ul-project-details-infos-shares">
                            <a href="#"><i class="flaticon-facebook"></i></a>
                            <a href="#"><i class="flaticon-twitter"></i></a>
                            <a href="#"><i class="flaticon-linkedin-big-logo"></i></a>
                            <a href="#"><i class="flaticon-youtube"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ul-project-details-nav">
                <a href="#"><i class="flaticon-back"></i> <span>Previous Project</span></a>
                <a href="#"><i class="flaticon-next"></i> <span>Next Project</span></a>
            </div>
        </div>
 @endsection
