@extends('site.layouts.app')

@section('content')
@include('site.layouts.breadcrumbs', [
    'title' => 'Donation Pending',
    'items' => [
        ['label' => 'Home', 'url' => route('home')],
        ['label' => 'Donation', 'url' => route('donation')],
        ['label' => 'Pending']
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
                                    <i class="flaticon-clock text-warning" style="font-size: 4rem;"></i>
                                </div>
                                <h2 class="ul-donation-details-title">Donation Pending Approval</h2>
                                <p class="ul-donation-details-summary-txt">Your donation has been submitted and is pending admin approval. We will review your donation and update you via email once it's approved.</p>
                                
                                <div class="ul-donation-details-form-bottom mt-4 text-center">
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