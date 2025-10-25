@extends('site.layouts.app')

@section('content')
<!-- BREADCRUMBS SECTION START -->
<section class="ul-breadcrumb ul-section-spacing">
    <div class="ul-container">
        <h2 class="ul-breadcrumb-title">{{ __('Confirm Password') }}</h2>
        <ul class="ul-breadcrumb-nav">
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><span class="separator"><i class="flaticon-right"></i></span></li>
            <li>{{ __('Confirm Password') }}</li>
        </ul>
    </div>
</section>
<!-- BREADCRUMBS SECTION END -->

<!-- CONFIRM PASSWORD SECTION START -->
<section class="ul-inner-contact ul-section-spacing">
    <div class="ul-section-heading justify-content-center text-center">
        <div>
            <span class="ul-section-sub-title">{{ __('Security Check') }}</span>
            <h2 class="ul-section-title">{{ __('Confirm Your Password to Continue') }}</h2>
        </div>
    </div>

    <div class="ul-inner-contact-container">
        <div class="text-center mb-4">
             {{ __('Please confirm your password before continuing.') }}
        </div>


        <form method="POST" action="{{ route('password.confirm') }}" class="ul-contact-form ul-form">
            @csrf

            <div class="row row-cols-1 ul-bs-row">
                <div class="col">
                    <div class="form-group">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="{{ __('Password') }}">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="col-12 text-center">
                    <button type="submit" class="ul-btn">
                         <i class="flaticon-fast-forward-double-right-arrows-symbol"></i> {{ __('Confirm Password') }}
                    </button>

                     @if (Route::has('password.request'))
                        <a class="btn btn-link mt-2" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</section>
<!-- CONFIRM PASSWORD SECTION END -->
@endsection
