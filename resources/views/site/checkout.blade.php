@extends('site.layouts.app')

@section('content')
@include('site.layouts.breadcrumbs', [
    'title' => 'Complete Donation',
    'items' => [
        ['label' => 'Home', 'url' => route('home')],
        ['label' => 'Donation', 'url' => route('donation')],
        ['label' => 'Checkout']
    ]
])

<div class="ul-donation-details ul-section-padding mt-5 mb-5">
    <div class="container">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-lg-8">
                <div class="ul-donation-details-wrapper">
                    <div class="ul-donation-details-content">
                        <div class="ul-donation-details-form-wrapper">
                            <h2 class="ul-donation-details-title">Complete Your Donation</h2>
                            
                            <div class="ul-donation-details-summary mb-4">
                                <h4>Donation Summary</h4>
                                <p>Amount: ${{ number_format($amount, 2) }}</p>
                                <p>Type: {{ ucfirst($donation_type) }} Donation</p>
                            </div>

                            <form id="payment-form" class="ul-donation-details-form">
                                @csrf
                                <input type="hidden" name="amount" value="{{ $amount }}">
                                <input type="hidden" name="donation_type" value="{{ $donation_type }}">
                                @if(isset($incident_id))
                                    <input type="hidden" name="incident_id" value="{{ $incident_id }}">
                                @endif

                                <div class="alert alert-danger d-none" id="error-message"></div>

                                <div class="ul-donation-details-personal-info">
                                    <h3 class="ul-donation-details-personal-info-title">Personal Info</h3>
                                    <p class="ul-donation-details-personal-info-sub-title">Your email address will not be published. Required fields are marked *</p>
                                    
                                    <div class="ul-donation-details-personal-info-form">
                                        <div class="row row-cols-2 row-cols-xxs-1 ul-bs-row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <input type="text" id="first_name" name="first_name" placeholder="First Name *" required>
                                                    <div class="invalid-feedback" id="first_name_error"></div>
                                                </div>
                                            </div>

                                            <div class="col">
                                                <div class="form-group">
                                                    <input type="text" id="last_name" name="last_name" placeholder="Last Name *" required>
                                                    <div class="invalid-feedback" id="last_name_error"></div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group">
                                                    <input type="email" id="email" name="email" placeholder="Email Address *" required>
                                                    <div class="invalid-feedback" id="email_error"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="ul-donation-details-payment-methods mt-3">
                                    <h3 class="ul-donation-details-payment-methods-title">Card Details</h3>
                                    <div id="card-element" class="form-control" style="padding: 15px; border: 1px solid #e0e0e0; border-radius: 8px; background: white;">
                                        <!-- Stripe Card Element will be inserted here -->
                                    </div>
                                    <div id="card-errors" class="invalid-feedback" role="alert"></div>
                                </div>

                                <div class="ul-donation-details-form-bottom text-center">
                                    <button type="submit" class="ul-btn" id="submit-button">
                                        <i class="flaticon-fast-forward-double-right-arrows-symbol"></i> Complete Donation
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Stripe
    const stripe = Stripe('{{ config('services.stripe.key') }}');
    const elements = stripe.elements();
    
    // Create card element with custom styling
    const card = elements.create('card', {
        style: {
            base: {
                fontSize: '16px',
                color: '#32325d',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#dc3545',
                iconColor: '#dc3545'
            }
        }
    });

    // Mount the card element
    card.mount('#card-element');

    // Get DOM elements
    const form = document.getElementById('payment-form');
    const submitButton = document.getElementById('submit-button');
    const errorMessage = document.getElementById('error-message');

    function showError(message) {
        errorMessage.textContent = message;
        errorMessage.classList.remove('d-none');
        submitButton.disabled = false;
        submitButton.innerHTML = '<i class="flaticon-fast-forward-double-right-arrows-symbol"></i> Complete Donation';
    }

    function clearErrors() {
        errorMessage.classList.add('d-none');
        document.getElementById('card-errors').textContent = '';
        ['first_name', 'last_name', 'email'].forEach(field => {
            document.getElementById(field).classList.remove('is-invalid');
            document.getElementById(`${field}_error`).textContent = '';
        });
    }

    // Handle form submission
    form.addEventListener('submit', async function(event) {
        event.preventDefault();
        clearErrors();
        submitButton.disabled = true;
        submitButton.innerHTML = '<i class="flaticon-fast-forward-double-right-arrows-symbol"></i> Processing...';

        try {
            const {paymentMethod, error} = await stripe.createPaymentMethod({
                type: 'card',
                card: card,
                billing_details: {
                    name: document.getElementById('first_name').value + ' ' + document.getElementById('last_name').value,
                    email: document.getElementById('email').value,
                },
            });

            if (error) {
                document.getElementById('card-errors').textContent = error.message;
                submitButton.disabled = false;
                submitButton.innerHTML = '<i class="flaticon-fast-forward-double-right-arrows-symbol"></i> Complete Donation';
                return;
            }

            // Add payment method ID to form data
            const formData = new FormData(form);
            formData.append('payment_method_id', paymentMethod.id);

            // Submit the form data
            const response = await fetch('{{ route('donation.process') }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            const result = await response.json();

            if (result.success) {
                window.location.href = '{{ route('donation.success') }}';
            } else {
                if (result.errors) {
                    // Handle validation errors
                    Object.keys(result.errors).forEach(field => {
                        const input = document.getElementById(field);
                        const errorDiv = document.getElementById(`${field}_error`);
                        if (input && errorDiv) {
                            input.classList.add('is-invalid');
                            errorDiv.textContent = result.errors[field][0];
                        }
                    });
                } else {
                    showError(result.message || 'An error occurred while processing your donation.');
                }
                submitButton.disabled = false;
                submitButton.innerHTML = '<i class="flaticon-fast-forward-double-right-arrows-symbol"></i> Complete Donation';
            }
        } catch (err) {
            console.error('Error:', err);
            showError('An unexpected error occurred. Please try again.');
            submitButton.disabled = false;
            submitButton.innerHTML = '<i class="flaticon-fast-forward-double-right-arrows-symbol"></i> Complete Donation';
        }
    });
});
</script>
@endpush
@endsection 