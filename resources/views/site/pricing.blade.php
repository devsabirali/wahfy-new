@extends('site.layouts.app')
@section('content')
        <!-- BREADCRUMBS SECTION START -->
        @include('site.layouts.breadcrumbs', [
            'title' => 'Pricing',
            'items' => [
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'Pricing']
            ]
        ])
        <!-- BREADCRUMBS SECTION END -->


        <section class="ul-pricing ul-section-spacing">
            <div class="ul-container">
                <div class="row ul-bs-row row-cols-lg-3 row-cols-sm-2 row-cols-1">
                    <!-- single plan -->
                    <div class="col">
                        <div class="ul-pricing-package">
                            <!-- heading -->
                            <div class="ul-pricing-package-heading">
                                <span class="ul-pricing-package-name">Basic</span>
                                <div class="ul-pricing-package-heading-bottom">
                                    <h3 class="ul-pricing-package-price">$19</h3>
                                    <div class="right">
                                        <span class="ul-pricing-package-duration"><span class="divider">/</span>Month</span>
                                    </div>
                                </div>
                                <p class="ul-pricing-package-descr">We care about their success. For us real We care about their success. For us real relationship.</p>
                            </div>

                            <!-- body -->
                            <div class="ul-pricing-package-body">
                                <ul class="ul-pricing-package-body-list">
                                    <li>Providing solutions</li>
                                    <li>Service that matters</li>
                                    <li>Giving our best</li>
                                    <li>24/7 Skilled Support</li>
                                    <li>We serve differently</li>
                                </ul>

                                <a href="#" class="ul-pricing-package-btn">Choose a Plan</a>
                            </div>
                        </div>
                    </div>

                    <!-- single plan -->
                    <div class="col">
                        <div class="ul-pricing-package">
                            <!-- heading -->
                            <div class="ul-pricing-package-heading">
                                <span class="ul-pricing-package-name">Standard</span>
                                <div class="ul-pricing-package-heading-bottom">
                                    <h3 class="ul-pricing-package-price">$59</h3>
                                    <div class="right">
                                        <span class="ul-pricing-package-duration"><span class="divider">/</span>Month</span>
                                    </div>
                                </div>
                                <p class="ul-pricing-package-descr">We care about their success. For us real We care about their success. For us real relationship.</p>
                            </div>

                            <!-- body -->
                            <div class="ul-pricing-package-body">
                                <ul class="ul-pricing-package-body-list">
                                    <li>Providing solutions</li>
                                    <li>Service that matters</li>
                                    <li>Giving our best</li>
                                    <li>24/7 Skilled Support</li>
                                    <li>We serve differently</li>
                                </ul>

                                <a href="#" class="ul-pricing-package-btn">Choose a Plan</a>
                            </div>
                        </div>
                    </div>

                    <!-- single plan -->
                    <div class="col">
                        <div class="ul-pricing-package">
                            <!-- heading -->
                            <div class="ul-pricing-package-heading">
                                <span class="ul-pricing-package-name">Premium</span>
                                <div class="ul-pricing-package-heading-bottom">
                                    <h3 class="ul-pricing-package-price">$110</h3>
                                    <div class="right">
                                        <span class="ul-pricing-package-duration"><span class="divider">/</span>Month</span>
                                    </div>
                                </div>
                                <p class="ul-pricing-package-descr">We care about their success. For us real We care about their success. For us real relationship.</p>
                            </div>

                            <!-- body -->
                            <div class="ul-pricing-package-body">
                                <ul class="ul-pricing-package-body-list">
                                    <li>Providing solutions</li>
                                    <li>Service that matters</li>
                                    <li>Giving our best</li>
                                    <li>24/7 Skilled Support</li>
                                    <li>We serve differently</li>
                                </ul>

                                <a href="#" class="ul-pricing-package-btn">Choose a Plan</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
  @endsection
