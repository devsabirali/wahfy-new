@extends('admin.layouts.app')

@section('title', 'Pay Contribution')

@section('content')
<div class="page-header">
    <div class="page-leftheader">
        <h4 class="page-title mb-0">Pay Contribution</h4>
    </div>
    <div class="page-rightheader ml-auto d-lg-flex d-none">
        @if(hasPermissionOrRole('read-contribution'))
        <a href="{{ route('admin.contributions.show', $contribution) }}" class="btn btn-secondary">
            <i class="fe fe-arrow-left mr-2"></i> Back to Contribution
        </a>
        @endif
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Payment Details</h3>
            </div>
            <div class="card-body">
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5>Contribution Information</h5>
                        <p><strong>Member:</strong> {{ $contribution->user->name }}</p>
                        <p><strong>Incident:</strong> {{ $contribution->incident->deceased_name }}</p>
                        <p><strong>Date of Death:</strong> {{ $contribution->incident->date_of_death ? $contribution->incident->date_of_death->format('M d, Y') : 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5>Payment Summary</h5>
                        <div class="bg-light p-3 rounded">
                            <div class="d-flex justify-content-between">
                                <span>Contribution Amount:</span>
                                <span class="font-weight-bold">${{ number_format($contribution->amount, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Admin Fee:</span>
                                <span>${{ number_format($contribution->admin_fee, 2) }}</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <span class="h5">Total Amount:</span>
                                <span class="h5 text-primary">${{ number_format($contribution->amount + $contribution->admin_fee, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                @if(hasPermissionOrRole('pay-contribution'))
                <form id="paymentForm" action="{{ route('admin.contributions.process-payment', $contribution) }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label>Payment Method</label>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="stripe" name="payment_method" value="stripe" class="custom-control-input" checked>
                                    <label class="custom-control-label" for="stripe">
                                        <i class="fe fe-credit-card mr-2"></i> Credit Card (Stripe)
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="offline" name="payment_method" value="offline" class="custom-control-input">
                                    <label class="custom-control-label" for="offline">
                                        <i class="fe fe-dollar-sign mr-2"></i> Offline Payment
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Stripe Payment Section -->
                    <div id="stripeSection">
                        <div class="alert alert-info">
                            <i class="fe fe-info mr-2"></i>
                            You will be redirected to Stripe's secure payment page to complete your payment.
                        </div>

                        <div id="stripe-payment-element">
                            <!-- Stripe Elements will be inserted here -->
                        </div>

                        <input type="hidden" name="stripe_payment_intent_id" id="stripe_payment_intent_id">
                    </div>

                    <!-- Offline Payment Section -->
                    <div id="offlineSection" style="display: none;">
                        <div class="alert alert-warning">
                            <i class="fe fe-alert-triangle mr-2"></i>
                            This payment will be recorded as pending and will need admin approval.
                        </div>

                        <div class="form-group">
                            <label for="payment_method_id">Payment Method *</label>
                            <select name="payment_method_id" id="payment_method_id" class="form-control">
                                <option value="">Select Payment Method</option>
                                @foreach($paymentMethods as $method)
                                    <option value="{{ $method->id }}">{{ $method->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary btn-lg" id="submitButton">
                            <i class="fe fe-credit-card mr-2"></i>
                            <span id="submitButtonText">Pay ${{ number_format($contribution->amount + $contribution->admin_fee, 2) }}</span>
                        </button>
                        <a href="{{ route('admin.contributions.show', $contribution) }}" class="btn btn-secondary btn-lg ml-2">
                            <i class="fe fe-x mr-2"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Payment Security</h3>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <i class="fe fe-shield text-success" style="font-size: 3rem;"></i>
                </div>
                <h5>Secure Payment</h5>
                <p class="text-muted">Your payment information is encrypted and secure. We use industry-standard SSL encryption to protect your data.</p>

                <h5>Payment Processing</h5>
                <ul class="list-unstyled">
                    <li><i class="fe fe-check text-success mr-2"></i> PCI DSS Compliant</li>
                    <li><i class="fe fe-check text-success mr-2"></i> 256-bit SSL Encryption</li>
                    <li><i class="fe fe-check text-success mr-2"></i> Secure Payment Gateway</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const stripe = Stripe('{{ config('services.stripe.key') }}');
    let elements;
    let paymentIntentId;

    // Toggle payment method sections
    document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const stripeSection = document.getElementById('stripeSection');
            const offlineSection = document.getElementById('offlineSection');
            const paymentMethodId = document.getElementById('payment_method_id');

            if (this.value === 'stripe') {
                stripeSection.style.display = 'block';
                offlineSection.style.display = 'none';
                paymentMethodId.required = false;
                // Auto-select the stripe payment method (ID 5 based on our earlier check)
                paymentMethodId.value = '5';
            } else {
                stripeSection.style.display = 'none';
                offlineSection.style.display = 'block';
                paymentMethodId.required = true;
                // Reset to default selection for offline payments
                paymentMethodId.value = '';
            }
        });
    });

    // Set initial payment method ID based on default selection
    const defaultPaymentMethod = document.querySelector('input[name="payment_method"]:checked');
    if (defaultPaymentMethod && defaultPaymentMethod.value === 'stripe') {
        document.getElementById('payment_method_id').value = '5';
    }

    // Initialize Stripe Elements
    async function initializeStripe() {
        try {
            console.log('Initializing Stripe Elements...');
            const response = await fetch('{{ route('admin.contributions.create-stripe-payment-intent', $contribution) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            console.log('Response status:', response.status);
            const data = await response.json();
            console.log('Response data:', data);

            if (!response.ok) {
                throw new Error(data.error || 'Failed to create payment intent');
            }

            const { client_secret, payment_intent_id } = data;
            paymentIntentId = payment_intent_id;
            document.getElementById('stripe_payment_intent_id').value = payment_intent_id;

            console.log('Creating Stripe elements with client secret:', client_secret);

            elements = stripe.elements({
                clientSecret: client_secret,
                appearance: {
                    theme: 'stripe',
                }
            });

            const paymentElement = elements.create('payment');
            paymentElement.mount('#stripe-payment-element');

            console.log('Stripe Elements initialized successfully');
        } catch (error) {
            console.error('Error initializing Stripe:', error);
            alert('Error initializing payment: ' + error.message);
        }
    }

    // Handle form submission
    document.getElementById('paymentForm').addEventListener('submit', async function(e) {
        console.log('Form submission started');
        const submitButton = document.getElementById('submitButton');
        const submitButtonText = document.getElementById('submitButtonText');
        const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;

        console.log('Payment method:', paymentMethod);

        submitButton.disabled = true;
        submitButtonText.textContent = 'Processing...';

        if (paymentMethod === 'stripe') {
            console.log('Processing Stripe payment');
            console.log('Payment intent ID:', paymentIntentId);
            console.log('Form data:', new FormData(document.getElementById('paymentForm')));

            // For now, let's test if the backend processing works by submitting the form directly
            // We'll add the Stripe confirmation later once we confirm the backend works
            console.log('Submitting form directly to test backend processing');
            // Don't prevent default - let the form submit normally for testing
        } else {
            console.log('Processing offline payment - allowing normal form submission');
        }
        // For offline payment, let the form submit normally (don't prevent default)
    });

    // Initialize Stripe when page loads
    initializeStripe();
});
</script>
@endpush

