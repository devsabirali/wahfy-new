@extends('site.layouts.app')

@section('content')
<!-- BREADCRUMBS SECTION START -->
<section class="ul-breadcrumb ul-section-spacing">
    <div class="ul-container">
        <h2 class="ul-breadcrumb-title">{{ __('Reset Password') }}</h2>
        <ul class="ul-breadcrumb-nav">
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><span class="separator"><i class="flaticon-right"></i></span></li>
            <li>{{ __('Reset Password') }}</li>
        </ul>
    </div>
</section>
<!-- BREADCRUMBS SECTION END -->

<!-- RESET PASSWORD SECTION START -->
<section class="ul-inner-contact ul-section-spacing">
    <div class="ul-section-heading justify-content-center text-center">
        <div>
            <span class="ul-section-sub-title">{{ __('Choose a New Password') }}</span>
            <h2 class="ul-section-title">{{ __('Reset Your Password') }}</h2>
        </div>
    </div>

    <div class="ul-inner-contact-container">
        <form method="POST" action="{{ route('password.update') }}" class="ul-contact-form ul-form">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="row row-cols-1 ul-bs-row">
                <div class="col">
                    <div class="form-group">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus placeholder="{{ __('Email Address') }}">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="col">
                    <div class="form-group">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="{{ __('Password') }}">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="col">
                    <div class="form-group">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="{{ __('Confirm Password') }}">
                    </div>
                </div>

                <div class="col-12 text-center">
                    <button type="submit" class="ul-btn">
                         <i class="flaticon-fast-forward-double-right-arrows-symbol"></i> {{ __('Reset Password') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</section>
<!-- RESET PASSWORD SECTION END -->
@endsection
