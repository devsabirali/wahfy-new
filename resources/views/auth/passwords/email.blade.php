@extends('site.layouts.app')

@section('content')
<!-- BREADCRUMBS SECTION START -->
<section class="ul-breadcrumb ul-section-spacing">
    <div class="ul-container">
        <h2 class="ul-breadcrumb-title">{{ __('Forgot Your Password?') }}</h2>
        <ul class="ul-breadcrumb-nav">
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><span class="separator"><i class="flaticon-right"></i></span></li>
            <li>{{ __('Forgot Your Password?') }}</li>
        </ul>
    </div>
</section>
<!-- BREADCRUMBS SECTION END -->

<!-- FORGOT PASSWORD SECTION START -->
<section class="ul-inner-contact ul-section-spacing">
    <div class="ul-section-heading justify-content-center text-center">
        <div>
            <span class="ul-section-sub-title">{{ __('Reset Password') }}</span>
            <h2 class="ul-section-title">{{ __('Enter Your Email Address') }}</h2>
        </div>
    </div>

    <div class="ul-inner-contact-container">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="ul-contact-form ul-form">
            @csrf

            <div class="row row-cols-1 ul-bs-row">
                <div class="col">
                    <div class="form-group">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="{{ __('Email Address') }}">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="col-12 text-center">
                    <button type="submit" class="ul-btn">
                         <i class="flaticon-fast-forward-double-right-arrows-symbol"></i> {{ __('Send Password Reset Link') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</section>
<!-- FORGOT PASSWORD SECTION END -->
@endsection
