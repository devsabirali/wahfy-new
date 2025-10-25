@extends('site.layouts.app')

@section('content')
@include('site.layouts.breadcrumbs', [
    'title' => 'Donation Successful',
    'items' => [
        ['label' => 'Home', 'url' => route('home')],
        ['label' => 'Donation', 'url' => route('donation')],
        ['label' => 'Success']
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
                            <div class="text-center">
                                <div class="mb-4">
                                    <i class="flaticon-check-mark text-success" style="font-size: 4rem;"></i>
                                </div>
                                <h2 class="ul-donation-details-title">Thank You for Your Donation!</h2>
                                <p class="ul-donation-details-summary-txt">Your generous contribution will make a real difference. We appreciate your support.</p>
                                <div  class="ul-donation-details-form-bottom mt-4 text-center" style="display: flex; justify-content: center; align-item-center">
                                    <a href="{{ route('home') }}" class="ul-btn">
                                        <i class="flaticon-fast-forward-double-right-arrows-symbol"></i> Return to Home
                                    </a>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 