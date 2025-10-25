@extends('site.layouts.app')
@section('content')
        

        @if(session('success'))
        <div class="ul-container">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
        @endif

        @if($errors->any())
        <div class="ul-container">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
        @endif

        <!-- CONTACT INFOS SECTION START -->
        <div class="ul-contact-infos">
            <div class="ul-section-spacing ul-container">
                <div class="row row-cols-md-3 row-cols-2 row-cols-xxs-1 ul-bs-row">
                    <!-- single info -->
                    <div class="col">
                        <div class="ul-contact-info">
                            <div class="icon"><i class="flaticon-phone-call"></i></div>
                            <div class="txt">
                                <span class="title">Phone number</span>
                                <a href="tel:{{ get_phone() }}">{{ get_phone() }}</a>
                            </div>
                        </div>
                    </div>
                    <!-- single info -->
                    <div class="col">
                        <div class="ul-contact-info">
                            <div class="icon"><i class="flaticon-comment"></i></div>
                            <div class="txt">
                                <span class="title">Email address</span>
                                <a href="mailto:{{ get_email() }}">{{ get_email() }}</a>
                            </div>
                        </div>
                    </div>
                    <!-- single info -->
                    <div class="col">
                        <div class="ul-contact-info">
                            <div class="icon"><i class="flaticon-location"></i></div>
                            <div class="txt">
                                <span class="title">Office Address</span>
                                <span class="descr">{{ get_address() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- CONTACT INFOS SECTION END -->

        <!-- MAPS SECTION START -->
        {{-- <div class="ul-contact-map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4273.369923927683!2d89.24843545559786!3d25.755317550773302!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39e32e0754341e5f%3A0xa50209e1e2d5aed5!2sRangpur%20Zoo!5e0!3m2!1sen!2sbd!4v1736854209235!5m2!1sen!2sbd"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    style="width: 100%; height: 450px; border: 0;">
            </iframe>
        </div> --}}
        <!-- MAPS SECTION END -->

        <!-- CONTACT SECTION START -->
        <!-- CONTACT SECTION START -->
        <section class="ul-inner-contact ul-section-spacing">
            <div class="ul-section-heading justify-content-center text-center">
                <div>
                    <span class="ul-section-sub-title">Contact us</span>
                    <h2 class="ul-section-title">Feel Free To Write Us Anytime</h2>
                </div>
            </div>

            <div class="ul-inner-contact-container">
                <form action="{{ route('contact.store') }}" method="POST" class="ul-contact-form ul-form">
                    @csrf
                    <div class="row row-cols-2 row-cols-xxs-1 ul-bs-row">
                        <div class="col">
                            <div class="form-group">
                                <input type="text"
                                       name="name"
                                       id="ul-contact-name"
                                       placeholder="Your Name"
                                       value="{{ old('name') }}"
                                       required
                                       class="form-control @error('name') is-invalid @enderror">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <input type="email"
                                       name="email"
                                       id="ul-contact-email"
                                       placeholder="Email Address"
                                       value="{{ old('email') }}"
                                       required
                                       class="form-control @error('email') is-invalid @enderror">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <input type="text"
                                       name="subject"
                                       id="ul-contact-subject"
                                       placeholder="Subject"
                                       value="{{ old('subject') }}"
                                       required
                                       class="form-control @error('subject') is-invalid @enderror">
                                @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <textarea name="message"
                                          id="ul-contact-msg"
                                          placeholder="Type your message"
                                          required
                                          class="form-control @error('message') is-invalid @enderror"
                                          rows="6">{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <button type="submit" class="ul-btn">
                                <i class="flaticon-fast-forward-double-right-arrows-symbol"></i> Get in Touch
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
@endsection

@push('styles')
<style>
    .alert {
        margin: 20px auto;
        max-width: 800px;
    }
    .invalid-feedback {
        display: block;
        margin-top: 5px;
    }
    .form-control.is-invalid {
        border-color: #dc3545;
    }
</style>
@endpush
