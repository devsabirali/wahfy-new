@extends('site.layouts.app')

@section('content')
<!-- BREADCRUMBS SECTION START -->
<section class="ul-breadcrumb ul-section-spacing">
    <div class="ul-container">
        <h2 class="ul-breadcrumb-title">Login</h2>
        <ul class="ul-breadcrumb-nav">
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><span class="separator"><i class="flaticon-right"></i></span></li>
            <li>Login</li>
        </ul>
    </div>
</section>
<!-- BREADCRUMBS SECTION END -->

<!-- LOGIN SECTION START -->
<section class="ul-inner-contact ul-section-spacing">
    <div class="ul-section-heading justify-content-center text-center">
        <div>
            <span class="ul-section-sub-title">Welcome Back</span>
            <h2 class="ul-section-title">Login to Your Account</h2>
        </div>
    </div>

    <div class="ul-inner-contact-container">
        <form method="POST" action="{{ route('login') }}" class="ul-contact-form ul-form">
            @csrf
            @if(session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="row row-cols-1 ul-bs-row">
                <div class="col">
                    <div class="form-group">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="off" autofocus placeholder="Email Address">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <style>
                    .form-check-input {
                        width: 1rem;
                        height: 1rem;
                    }

                    .form-check-label {
                        margin-left: 0.5rem;
                        margin-bottom: 0;
                    }

                    .remember-group {
                        display: flex;
                        align-items: center;
                        justify-content: space-between;
                        width: 100%;
                    }

                    .remember-left {
                        display: flex;
                        align-items: center;
                    }
                    #remember{
                        width: 20px;
                        height: 20px;
                    }
                    .btn-link {
                        text-decoration: none;
                        font-size: 0.95rem;
                    }
                </style>

                <div class="col">
                    <div class="form-group remember-group">
                        <div class="remember-left">
                            <input class="" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">{{ __('Remember Me') }}</label>
                        </div>

                        @if (Route::has('password.request'))
                           <div class="links">
                                <a class="btn" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                           </div>
                        @endif
                    </div>
                </div>


                <div class="col-12 text-center">
                    <button type="submit" class="ul-btn">
                        <i class="flaticon-fast-forward-double-right-arrows-symbol"></i> {{ __('Login') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</section>
<!-- LOGIN SECTION END -->
@endsection
