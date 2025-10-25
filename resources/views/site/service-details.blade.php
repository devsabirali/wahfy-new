@extends('site.layouts.app')
@section('content')
        <!-- BREADCRUMBS SECTION START -->
        @include('site.layouts.breadcrumbs', [
            'title' => 'Service Details',
            'items' => [
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'Services', 'url' => route('services')],
                ['label' => 'Service Details']
            ]
        ])
        <!-- BREADCRUMBS SECTION END -->


        <section class="ul-service-details ul-section-spacing">
            <div class="ul-container">
                <div>
                    <div class="ul-service-details-img">
                        <img src="assets/img/service-details-1.jpg" alt="Image">
                    </div>
                    <div class="ul-service-details-txt">
                        <h2 class="ul-service-details-title">Development Programs</h2>
                        <p class="ul-service-details-descr">BaseCreate is pleased to announce that it has been commissioned by Leighton Asia reposition its brand. We will help Leighton Asia evolve its brand strategy, For almost 50 years Leighton Asia, one of the region's largest and most respected construction companies, has been progressively building for a better future by </p>

                        <p class="ul-service-details-descr">For almost 50 years Leighton Asia, one of the region's largest and most respected construction companies, has been progressively building for a better future by leveraging international expertise with local intelligence. In that time Leighton has delivered some of Asia's prestigious buildings and transformational infrastructure projects.</p>

                        <div class="ul-service-details-inner-block">
                            <h3 class="ul-service-details-inner-title">Remarking Services</h3>
                            <p class="ul-service-details-descr">For almost 50 years Leighton Asia, one of the region's largest and most respected construction companies, has been progressively building for a better future by leveraging international expertise with local intelligence. In that time Leighton has delivered some of Asia's prestigious buildings and transformational infrastructure projects.</p>
                        </div>
                    </div>

                    <div class="ul-service-details-video-cover">
                        <img src="assets/img/service-details-video-cover.jpg" alt="Video Cover">
                        <a href="https://youtu.be/C2FFe5FiAqc?si=8p0Skg8lyxgHQCpg" data-fslightbox="Video">Play Video</a>
                    </div>

                    <div class="ul-service-details-txt">
                        <p class="ul-service-details-descr">Leighton Asia's brand refreshment will help position the company to meet the challenges of future, as it seeks to lead the industry in technological innovation and sustainable building practices to deliver long-lasting value for its clients.Leighton Asia's brand refreshment will help position the company meet the challenges of future, as it seeks to lead the industry in technological innovation and sustainable building practices to deliver long-lasting value for its clients.</p>

                        <div class="ul-service-details-inner-block">
                            <h3 class="ul-service-details-inner-title">Services All Details</h3>
                            <p class="ul-service-details-descr">Cast obscure badger jeep quail congenialy when changed as cat jeepers affectionate thus facilisi goodness this far like ipsum dolor sit amet, consectetur adipisicing elits eiusmod tempo incididunt et laboret dolore magna aliqua enim ad minim. Eveniet in vulputate esse molestie consequat, illum Eveniet in vulputate esse molestie dolore .</p>

                            <ul>
                                <li>Creating and editing content</li>
                                <li>Workflows, reporting, and content organization</li>
                                <li>User & role-based administration and security</li>
                                <li>Flexibility, scalability, and performance and analysis</li>
                                <li>Multilingual content capabilities</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endsection
