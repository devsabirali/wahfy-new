@extends('admin.layouts.app')

@section('title', 'Registration Payment')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        @php
            $breadcrumbs = [
                ['label' => 'Dashboard', 'url' => '/dashboard'],
                ['label' => 'Registration Payment', 'url' => '']
            ];
        @endphp
        @include('admin.layouts.page-title', ['breadcrumbs' => $breadcrumbs])

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    {{-- Card Header --}}
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Complete Your Registration</h4>
                    </div>

                    {{-- Card Body --}}
                    <div class="card-body">

                        {{-- Display Validation Errors --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Amount --}}
                        <div class="mb-4 text-center">
                            <h4 class="fw-bold">Amount to Pay:
                                <span class="text-primary">Rs {{ number_format($amount, 2) }}</span>
                            </h4>
                        </div>

                        {{-- Stripe Payment Form --}}
                        <form action="{{ route('admin.payments.registration_store') }}" method="POST" id="payment-form">
                            @csrf
                            <input type="hidden" name="charge_id" value="{{ $chargeId }}">
                            <input type="hidden" name="payment_method_id" value="{{ $methodId }}">
                            <input type="hidden" name="amount" value="{{ $amount }}">

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="card-element" class="form-label">Card Details <span class="text-danger">*</span></label>
                                    <div id="card-element" class="form-control py-3">
                                        <!-- Stripe Elements will be inserted here -->
                                    </div>
                                    <div id="card-errors" class="text-danger mt-2 small" role="alert"></div>
                                </div>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-credit-card me-1"></i> Pay Now
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe("{{ config('services.stripe.key') }}"); // public key
    const elements = stripe.elements();
    const card = elements.create('card', { hidePostalCode: true });
    card.mount('#card-element');

    const form = document.getElementById('payment-form');
    let submitting = false;

    form.addEventListener('submit', async (event) => {
        if (submitting) return;
        event.preventDefault();
        document.getElementById('card-errors').textContent = "";

        const { paymentMethod, error } = await stripe.createPaymentMethod({
            type: 'card',
            card: card,
        });

        if (error) {
            document.getElementById('card-errors').textContent = error.message;
        } else {
            if (!form.querySelector('input[name="stripe_token"]')) {
                let input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'stripe_token';
                input.value = paymentMethod.id;
                form.appendChild(input);
            }
            submitting = true;
            form.submit();
        }
    });
</script>
@endpush
