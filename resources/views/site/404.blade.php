
@extends('site.layouts.app')
@section('content')
        <!-- BREADCRUMBS SECTION START -->
        <section class="ul-breadcrumb ul-section-spacing">
            <div class="ul-container">
                <h2 class="ul-breadcrumb-title">Error</h2>
                <ul class="ul-breadcrumb-nav">
                    <li><a href="index.html">Home</a></li>
                    <li><span class="separator"><i class="flaticon-right"></i></span></li>
                    <li>Error</li>
                </ul>
            </div>
        </section>
        <!-- BREADCRUMBS SECTION END -->


        <section class="ul-404 ul-section-spacing text-center">
            <div class="ul-404-container">
                <div class="ul-404-img">
                    <img src="assets/img/404-img.png" alt="Image">
                </div>
                <h2 class="ul-section-title">Oops! Somethings Went Wrong Please Try Again Later</h2>
                <p>Sorry about that, but the page you looking is not available now</p>
                <a href="index.html" class="ul-btn"><i class="flaticon-fast-forward-double-right-arrows-symbol"></i> Back to Home</a>
            </div>
        </section>
@endsection
