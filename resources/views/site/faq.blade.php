@extends('site.layouts.app')
@section('content')
        <!-- BREADCRUMBS SECTION START -->
        @include('site.layouts.breadcrumbs', [
            'title' => 'FAQS',
            'items' => [
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'FAQS']
            ]
        ])
        <!-- BREADCRUMBS SECTION END -->


        <!-- FAQ SECTION START -->
        <section class="ul-why-join ul-section-spacing">
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
        </section>
        <!-- FAQ SECTION END -->
   @endsection
