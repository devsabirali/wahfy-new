@extends('site.layouts.app')
@section('content')
        <!-- BREADCRUMBS SECTION START -->
        @include('site.layouts.breadcrumbs', [
            'title' => 'Donation Details',
            'items' => [
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'Donation Details']
            ]
        ])
        <!-- BREADCRUMBS SECTION END -->


        <div class="ul-container ul-section-spacing">
            <div class="row gx-0 gy-4 flex-column-reverse flex-lg-row"> 

            <div class="col-md-2"></div>
                <!-- donation details content -->
                <div class="col-lg-8">
                    <div class="ul-donation-details">
                        <div class="ul-donation-details-img">
                        @if($incident->thumbnail_path)
                            <img src="{{ Storage::url($incident->thumbnail_path) }}" alt="{{ $incident->deceased_name }}">
                        @elseif($incident->images->isNotEmpty())
                            <img src="{{ Storage::url($incident->images->first()->image_path) }}" alt="{{ $incident->deceased_name }}">
                        @else
                            <img src="{{ asset('assets/img/donation-1.jpg') }}" alt="{{ $incident->deceased_name }}">
                        @endif
                        </div>
                        <h2 class="ul-donation-details-raised">${{ number_format($incident->amount, 2) }}<span class="target">of ${{ number_format($incident->amount * 1.2, 2) }} raised</span></h2>
                        <div class="ul-donation-progress ul-donation-progress-2">
                            <div class="donation-progress-container ul-progress-container">
                                <div class="donation-progressbar ul-progressbar" data-ul-progress-value="95">
                                    <div class="donation-progress-label ul-progress-label"></div>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="ul-donation-details-notice">
                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14.0003 20.6667C14.3781 20.6667 14.695 20.5387 14.951 20.2827C15.207 20.0267 15.3345 19.7103 15.3337 19.3334C15.3328 18.9565 15.2048 18.6401 14.9497 18.3841C14.6945 18.1281 14.3781 18.0001 14.0003 18.0001C13.6225 18.0001 13.3061 18.1281 13.051 18.3841C12.7959 18.6401 12.6679 18.9565 12.667 19.3334C12.6661 19.7103 12.7941 20.0272 13.051 20.2841C13.3079 20.541 13.6243 20.6685 14.0003 20.6667ZM14.0003 15.3334C14.3781 15.3334 14.695 15.2054 14.951 14.9494C15.207 14.6934 15.3345 14.377 15.3337 14.0001V8.66675C15.3337 8.28897 15.2057 7.97253 14.9497 7.71741C14.6937 7.4623 14.3772 7.3343 14.0003 7.33341C13.6234 7.33253 13.307 7.46053 13.051 7.71741C12.795 7.9743 12.667 8.29075 12.667 8.66675V14.0001C12.667 14.3779 12.795 14.6947 13.051 14.9507C13.307 15.2067 13.6234 15.3343 14.0003 15.3334ZM14.0003 27.3334C12.1559 27.3334 10.4226 26.9832 8.80033 26.2827C7.17811 25.5823 5.76699 24.6325 4.56699 23.4334C3.36699 22.2343 2.41722 20.8232 1.71766 19.2001C1.01811 17.577 0.667883 15.8436 0.666994 14.0001C0.666105 12.1565 1.01633 10.4232 1.71766 8.80008C2.41899 7.17697 3.36877 5.76586 4.56699 4.56675C5.76522 3.36764 7.17633 2.41786 8.80033 1.71741C10.4243 1.01697 12.1577 0.666748 14.0003 0.666748C15.843 0.666748 17.5763 1.01697 19.2003 1.71741C20.8243 2.41786 22.2354 3.36764 23.4337 4.56675C24.6319 5.76586 25.5821 7.17697 26.2843 8.80008C26.9865 10.4232 27.3363 12.1565 27.3337 14.0001C27.331 15.8436 26.9808 17.577 26.283 19.2001C25.5852 20.8232 24.6354 22.2343 23.4337 23.4334C22.2319 24.6325 20.8208 25.5827 19.2003 26.2841C17.5799 26.9854 15.8465 27.3352 14.0003 27.3334Z" fill="var(--ul-primary)" />
                            </svg>
                            <p>
                                <strong>Notice</strong>: Test mode is enabled. While in test mode no live donations are processed.
                            </p>
                        </div> -->

                        <form id="payment-form" class="ul-donation-details-form">
                            @csrf
                            <input type="hidden" name="incident_id" value="{{ $incident->id }}">
                            
                            <!-- select amount -->
                            <div class="ul-donation-details-donate-form-wrapper">
                                <div class="selected-amount"><span class="currency">$</span> <span class="number">10.00</span></div>
                                <div class="ul-donate-form">
                                    <div>
                                        <input type="radio" name="donate-amount" id="donate-amount-1" value="10" checked hidden>
                                        <label for="donate-amount-1" class="ul-donate-form-label">$10</label>
                                    </div>

                                    <div>
                                        <input type="radio" name="donate-amount" id="donate-amount-2" value="20" hidden>
                                        <label for="donate-amount-2" class="ul-donate-form-label">$20</label>
                                    </div>

                                    <div>
                                        <input type="radio" name="donate-amount" id="donate-amount-3" value="30" hidden>
                                        <label for="donate-amount-3" class="ul-donate-form-label">$30</label>
                                    </div>

                                    <div>
                                        <input type="radio" name="donate-amount" id="donate-amount-4" value="40" hidden>
                                        <label for="donate-amount-4" class="ul-donate-form-label">$40</label>
                                    </div>

                                    <div>
                                        <input type="radio" name="donate-amount" id="donate-amount-5" value="50" hidden>
                                        <label for="donate-amount-5" class="ul-donate-form-label">$50</label>
                                    </div>

                                    <div class="custom-amount-wrapper">
                                        <input type="radio" name="donate-amount" id="custom-amount" value="custom">
                                        <label for="donate-amount-custom" class="ul-donate-form-label">
                                            <input type="number" name="custom-amount" id="donate-amount-custom" placeholder="Custom Amount" class="ul-donate-form-custom-input">
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- select payment methods -->
                            <div class="ul-donation-details-payment-methods">
                                <h3 class="ul-donation-details-payment-methods-title">Card Details</h3>
                                <div id="card-element" class="form-control" style="padding: 15px; border: 1px solid #e0e0e0; border-radius: 8px; background: white;"></div>
                                <div id="card-errors" class="text-danger" style="display: none; margin-top: 10px; color: #dc3545; font-size: 14px;"></div>
                            </div>

                            <!-- enter personal info -->
                            <div class="ul-donation-details-personal-info mt-3">
                                <h3 class="ul-donation-details-personal-info-title">Personal Info</h3>
                                <p class="ul-donation-details-personal-info-sub-title">Your email address will not be published. Required fields are marked *</p>
                                <div class="ul-donation-details-personal-info-form">
                                    <div class="row row-cols-2 row-cols-xxs-1 ul-bs-row">
                                        <div class="col">
                                            <div class="form-group">
                                                <input type="text" name="first_name" placeholder="First Name *" required>
                                            </div>
                                        </div>

                                        <div class="col">
                                            <div class="form-group">
                                                <input type="text" name="last_name" placeholder="Last Name *" required>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <input type="email" name="email" placeholder="Email Address *" required>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="ul-donation-details-form-bottom">
                                    <button type="submit" class="ul-btn" id="submit-button">
                                        <i class="flaticon-fast-forward-double-right-arrows-symbol"></i> Donate Now
                                    </button>
                                    <span class="donation-total">Donation Total: <span class="number">$10</span></span>
                                </div>
                            </div>
                        </form>

                        <div class="ul-donation-details-summary">
                            <h3 class="ul-donation-details-summary-title">Details</h3>
                            <div class="ul-donation-details-summary-txt">
                                <p>{{ $incident->description }}</p>
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
    const cardErrors = document.getElementById('card-errors');
    const form = document.getElementById('payment-form');
    const submitButton = document.getElementById('submit-button');
    const amountRadios = document.getElementsByName('donate-amount');
    const customAmountInput = document.getElementById('donate-amount-custom');
    const donationTotal = document.querySelector('.donation-total .number');

    // Handle real-time card validation
    card.on('change', function(event) {
        if (event.error) {
            cardErrors.textContent = event.error.message;
            cardErrors.style.display = 'block';
        } else {
            cardErrors.style.display = 'none';
        }
    });

    // Handle amount selection
    function updateDonationTotal() {
        let amount = 10; // Default amount
        const selectedAmount = document.querySelector('input[name="donate-amount"]:checked');
        
        if (selectedAmount.value === 'custom' && customAmountInput.value) {
            amount = parseFloat(customAmountInput.value);
        } else {
            amount = parseFloat(selectedAmount.value);
        }
        
        donationTotal.textContent = `$${amount.toFixed(2)}`;
    }

    amountRadios.forEach(radio => {
        radio.addEventListener('change', updateDonationTotal);
    });

    customAmountInput.addEventListener('input', function() {
        if (document.getElementById('custom-amount').checked) {
            updateDonationTotal();
        }
    });

    // Handle form submission
    form.addEventListener('submit', async function(event) {
        event.preventDefault();
        submitButton.disabled = true;
        submitButton.innerHTML = '<i class="flaticon-fast-forward-double-right-arrows-symbol"></i> Processing...';

        const amount = parseFloat(donationTotal.textContent.replace('$', ''));

        try {
            // Create payment method first
            const { paymentMethod, error: paymentMethodError } = await stripe.createPaymentMethod({
                type: 'card',
                card: card,
                billing_details: {
                    name: document.querySelector('input[name="first_name"]').value + ' ' + 
                          document.querySelector('input[name="last_name"]').value,
                    email: document.querySelector('input[name="email"]').value
                }
            });

            if (paymentMethodError) {
                console.error('Payment method error:', paymentMethodError);
                throw new Error(paymentMethodError.message);
            }

            console.log('Payment method created:', paymentMethod);

            // Create payment intent
            const response = await fetch('{{ route('donation.process') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    amount: amount,
                    incident_id: document.querySelector('input[name="incident_id"]').value,
                    first_name: document.querySelector('input[name="first_name"]').value,
                    last_name: document.querySelector('input[name="last_name"]').value,
                    email: document.querySelector('input[name="email"]').value,
                    donation_type: 'incident',
                    payment_method_id: paymentMethod.id
                })
            });

            const data = await response.json();
            console.log('Payment intent response:', data);

            if (!data.success) {
                throw new Error(data.message || 'Failed to create payment intent');
            }

            // Since the payment is already confirmed on the server side (confirm: true),
            // we don't need to confirm it again on the client side
            if (data.clientSecret) {
                // Payment successful - complete the donation
                const completeResponse = await fetch('{{ route('donation.complete') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        amount: amount,
                        incident_id: document.querySelector('input[name="incident_id"]').value,
                        first_name: document.querySelector('input[name="first_name"]').value,
                        last_name: document.querySelector('input[name="last_name"]').value,
                        email: document.querySelector('input[name="email"]').value,
                        payment_method: 'card',
                        payment_intent_id: data.paymentIntentId,
                        donation_type: 'incident'
                    })
                });

                const completeData = await completeResponse.json();
                console.log('Complete donation response:', completeData);

                if (completeData.success) {
                    window.location.href = '{{ route('donation.success') }}';
                } else {
                    throw new Error(completeData.message || 'Failed to complete donation');
                }
            } else {
                throw new Error('No client secret received from server');
            }
        } catch (error) {
            console.error('Payment error:', error);
            cardErrors.textContent = error.message;
            cardErrors.style.display = 'block';
            submitButton.disabled = false;
            submitButton.innerHTML = '<i class="flaticon-fast-forward-double-right-arrows-symbol"></i> Donate Now';
        }
    });
});
</script>
@endpush
@endsection
