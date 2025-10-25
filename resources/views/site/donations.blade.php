@extends('site.layouts.app')
@section('content')
        <!-- BREADCRUMBS SECTION START -->
        @include('site.layouts.breadcrumbs', [
            'title' => 'Donation Listing',
            'items' => [
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'Donation Listing']
            ]
        ])
        <!-- BREADCRUMBS SECTION END -->

        <!-- DONTATIONS SECTION START -->
        <section class="ul-section-spacing overflow-hidden">
            <!-- DONTATIONS Grid -->
            <div class="ul-container wow animate__fadeInUp">
                @if($incidents->isEmpty())
                    <div class="alert alert-info text-center">
                        <h4>No verified incidents available at the moment.</h4>
                        <p>Please check back later for new donation opportunities.</p>
                    </div>
                @else
                    <div class="row ul-bs-row row-cols-xl-4 row-cols-md-3 row-cols-2 row-cols-xxs-1">
                        @foreach($incidents as $incident)
                        <!-- single item -->
                        <div class="col">
                            <div class="ul-donation ul-donation--inner">
                                <div class="ul-donation-img">
                                    @if($incident->thumbnail_path)
                                        <img src="{{ Storage::url($incident->thumbnail_path) }}" alt="{{ $incident->deceased_name }}">
                                    @elseif($incident->images->isNotEmpty())
                                        <img src="{{ Storage::url($incident->images->first()->image_path) }}" alt="{{ $incident->deceased_name }}">
                                    @else
                                        <img src="{{ asset('assets/img/donation-1.jpg') }}" alt="{{ $incident->deceased_name }}">
                                    @endif
                                    <span class="tag">{{ $incident->user->name }}</span>
                                </div>
                                <div class="ul-donation-txt">
                                    <div class="ul-donation-progress">
                                        <div class="donation-progress-container ul-progress-container">
                                            <div class="donation-progressbar ul-progressbar" data-ul-progress-value="{{ ($incident->amount / 100) }}">
                                                <div class="donation-progress-label ul-progress-label"></div>
                                            </div>
                                        </div>
                                        <div class="ul-donation-progress-labels">
                                            <span class="ul-donation-progress-label">Raised : ${{ number_format($incident->amount, 2) }}</span>
                                            <span class="ul-donation-progress-label">Goal : ${{ number_format($incident->amount * 1.2, 2) }}</span>
                                        </div>
                                    </div>
                                    <a href="{{ route('donation.detail', ['incident' => $incident->id]) }}" class="ul-donation-title">{{ $incident->deceased_name }}</a>
                                    <p class="ul-donation-descr">{{ Str::limit($incident->description, 100) }}</p>
                                    <a href="{{ route('donation.detail', ['incident' => $incident->id]) }}" class="ul-donation-btn">Donate now <i class="flaticon-up-right-arrow"></i></a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- pagination -->
                    <div class="ul-pagination">
                        {{ $incidents->links() }}
                    </div>
                @endif
            </div>
        </section>
        <!-- DONTATIONS SECTION END -->
@endsection

