@extends('site.layouts.app')

@section('content')
<!-- BREADCRUMBS SECTION START -->
<section class="ul-breadcrumb ul-section-spacing">
    <div class="ul-container">
        <h2 class="ul-breadcrumb-title">{{ __('Verify Your Email Address') }}</h2>
        <ul class="ul-breadcrumb-nav">
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><span class="separator"><i class="flaticon-right"></i></span></li>
            <li>{{ __('Verify Your Email Address') }}</li>
        </ul>
    </div>
</section>
<!-- BREADCRUMBS SECTION END -->

<!-- VERIFY EMAIL SECTION START -->
<section class="ul-inner-contact ul-section-spacing">
    <div class="ul-section-heading justify-content-center text-center">
        <div>
            <span class="ul-section-sub-title">{{ __('Email Verification') }}</span>
            <h2 class="ul-section-title">{{ __('Please Verify Your Email Address') }}</h2>
        </div>
    </div>

    <div class="ul-inner-contact-container text-center">
        @if (session('resent'))
            <div class="alert alert-success" role="alert">
                {{ __('A fresh verification link has been sent to your email address.') }}
            </div>
        @endif

        <p class="mb-3">
            {{ __('Before proceeding, please check your email for a verification link.') }}
        </p>
        <p class="mb-3">
             {{ __('If you did not receive the email') }},
        </p>
        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
        </form>
    </div>
</section>
<!-- VERIFY EMAIL SECTION END -->
@endsection
