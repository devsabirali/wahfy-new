<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StripePaymentController extends Controller
{
    public function createIntent(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));
        $intent = PaymentIntent::create([
            'amount' => $request->amount * 100, // in cents
            'currency' => 'usd',
        ]);
        return response()->json(['clientSecret' => $intent->client_secret]);
    }

    public function charge(Request $request)
    {
        // Handle webhook or confirmation here if needed
        // Save donation record, send email, etc.
        return response()->json(['success' => true]);
    }
}
