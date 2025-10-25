@extends('site.layouts.app')

@section('content')
<style>
    .custom-radio-small {
    width: 20px ;
    height: 20px ;
    min-width: 16px ;
    min-height: 16px ;
    max-width: 16px ;
    max-height: 16px ; 
    border-radius: 50% ; 
}
.radio-btn-group {
    display: flex;
    justify-content: start;
    gap: 20px;
    margin-bottom: 1rem;
}
.radio-btn-option {
    position: relative;
}
.radio-btn-option input[type="radio"] {
    opacity: 0;
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    margin: 0;
    cursor: pointer;
}
.radio-btn-option label {
    display: inline-block;
    padding: 10px 24px;
    border: 2px solid #0078B8;
    border-radius: 4px;
    background: #fff;
    color: #0078B8;
    font-weight: 500;
    cursor: pointer;
    transition: background 0.2s, color 0.2s;
    min-width: 140px;
    text-align: center;
}
.radio-btn-option input[type="radio"]:checked + label {
    background: #0078B8;
    color: #fff;
}
</style>
<!-- BREADCRUMBS SECTION START -->
<section class="ul-breadcrumb ul-section-spacing">
    <div class="ul-container">
        <h2 class="ul-breadcrumb-title">Register</h2>
        <ul class="ul-breadcrumb-nav">
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><span class="separator"><i class="flaticon-right"></i></span></li>
            <li>Register</li>
        </ul>
    </div>
</section>
<!-- BREADCRUMBS SECTION END -->

<!-- REGISTER SECTION START -->
<section class="ul-inner-contact ul-section-spacing">
    <div class="ul-section-heading justify-content-center text-center">
        <div>
            <span class="ul-section-sub-title">Create Account</span>
            <h2 class="ul-section-title">Register New Account</h2>
        </div>
    </div>

    <div class="ul-inner-contact-container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="alert alert-info mb-4">
            <h5 class="alert-heading">Registration Fee Information</h5>
            <p class="mb-0">A registration fee of $2 is required for all account types (Individual Member, Group Leader, or Family Leader).</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="ul-contact-form ul-form">
            @csrf
            <div class="row row-cols-1 ul-bs-row">
                <!-- Account Type -->
                <div class="col mb-4">
                    <div class="form-group">
                        <label class="d-block mb-3">Account Type <span class="text-danger">*</span></label>
                        <div class="radio-btn-group">
                            <div class="radio-btn-option">
                                <input type="radio" id="individual" name="user_type" value="individual"
                                    {{ old('user_type', 'individual') == 'individual' ? 'checked' : '' }} required>
                                <label for="individual">Individual Member</label>
                            </div>
                            <div class="radio-btn-option">
                                <input type="radio" id="group_leader" name="user_type" value="group_leader"
                                    {{ old('user_type') == 'group_leader' ? 'checked' : '' }}>
                                <label for="group_leader">Group Leader</label>
                            </div>
                            <div class="radio-btn-option">
                                <input type="radio" id="family_leader" name="user_type" value="family_leader"
                                    {{ old('user_type') == 'family_leader' ? 'checked' : '' }}>
                                <label for="family_leader">Family Leader</label>
                            </div>
                        </div>
                        @error('user_type')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <!-- Name Fields -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="first_name">First Name <span class="text-danger">*</span></label>
                            <input id="first_name" type="text"
                                   class="form-control @error('first_name') is-invalid @enderror"
                                   name="first_name"
                                   value="{{ old('first_name') }}"
                                   required
                                   autocomplete="off"
                                   autofocus
                                   placeholder="Enter your first name">
                            @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="middle_name">Middle Name</label>
                            <input id="middle_name" type="text"
                                   class="form-control @error('middle_name') is-invalid @enderror"
                                   name="middle_name"
                                   value="{{ old('middle_name') }}"
                                   autocomplete="off"
                                   placeholder="Enter your middle name">
                            @error('middle_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="last_name">Last Name <span class="text-danger">*</span></label>
                            <input id="last_name" type="text"
                                   class="form-control @error('last_name') is-invalid @enderror"
                                   name="last_name"
                                   value="{{ old('last_name') }}"
                                   required
                                   autocomplete="off"
                                   placeholder="Enter your last name">
                            @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email Address <span class="text-danger">*</span></label>
                            <input id="email" type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   name="email"
                                   value="{{ old('email') }}"
                                   required
                                   autocomplete="off"
                                   placeholder="Enter your email address">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone">Phone Number <span class="text-danger">*</span></label>
                            <input id="phone" type="text"
                                   class="form-control @error('phone') is-invalid @enderror"
                                   name="phone"
                                   value="{{ old('phone') }}"
                                   required
                                   autocomplete="off"
                                   placeholder="Enter your phone number">
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- ID Number -->
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="form-group">
                            <label for="id_number">ID Number <span class="text-danger">*</span></label>
                            <input id="id_number" type="text"
                                   class="form-control @error('id_number') is-invalid @enderror"
                                   name="id_number"
                                   value="{{ old('id_number') }}"
                                   required
                                   autocomplete="off"
                                   placeholder="Enter your ID number">
                            @error('id_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Password Fields -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <input id="password" type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   name="password"
                                   required
                                   autocomplete="new-password"
                                   placeholder="Enter your password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password <span class="text-danger">*</span></label>
                            <input id="password_confirmation" type="password"
                                   class="form-control"
                                   name="password_confirmation"
                                   required
                                   autocomplete="new-password"
                                   placeholder="Confirm your password">
                        </div>
                    </div>
                </div>

                <div class="col-12 text-center">
                    <button type="submit" class="ul-btn">
                        <i class="flaticon-fast-forward-double-right-arrows-symbol"></i>
                        {{ __('Register') }}
                    </button>
                </div>

                <div class="col-12 text-center mt-4">
                    <p class="mb-0">
                        Already have an account?
                        <a href="{{ route('login') }}" class="btn-link">Login here</a>
                    </p>
                </div>
            </div>
        </form>
    </div>
</section>
<!-- REGISTER SECTION END -->
@endsection
