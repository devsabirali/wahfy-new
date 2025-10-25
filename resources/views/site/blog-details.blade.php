@extends('site.layouts.app')
@section('content')
        <!-- BREADCRUMBS SECTION START -->
        @include('site.layouts.breadcrumbs', [
            'title' => 'Blog Details',
            'items' => [
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'Blog', 'url' => route('blog')],
                ['label' => 'Blog Details']
            ]
        ])
        <!-- BREADCRUMBS SECTION END -->


        <!-- BLOG SECTION START -->
        <div class="ul-section-spacing">
            <div class="ul-container">
                <div class="row ul-bs-row gy-5 flex-column-reverse flex-md-row">
                    <!-- sidebar -->
                    <div class="col-lg-4 col-md-5">
                        <div class="ul-inner-sidebar">
                            <!-- single widget /search -->
                            <div class="ul-inner-sidebar-widget ul-inner-sidebar-search">
                                <h3 class="ul-inner-sidebar-widget-title">Search</h3>
                                <div class="ul-inner-sidebar-widget-content">
                                    <form action="{{ route('search') }}" class="ul-blog-search-form">
                                        <input type="search" name="q" id="ul-blog-search" placeholder="Search Here">
                                        <button type="submit"><span class="icon"><i class="flaticon-search"></i></span></button>
                                    </form>
                                </div>
                            </div>

                            <!-- single widget / Categories -->
                            <div class="ul-inner-sidebar-widget categories">
                                <h3 class="ul-inner-sidebar-widget-title">Categories</h3>
                                <div class="ul-inner-sidebar-widget-content">
                                    <div class="ul-inner-sidebar-categories">
                                        @foreach($categories as $category)
                                            <a href="{{ route('blog', ['category' => $category->id]) }}">
                                                {{ $category->name }} <span>({{ $category->blogs_count }})</span>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- single widget / Recent Posts -->
                            <div class="ul-inner-sidebar-widget posts">
                                <h3 class="ul-inner-sidebar-widget-title">Recent Posts</h3>
                                <div class="ul-inner-sidebar-widget-content">
                                    <div class="ul-inner-sidebar-posts">
                                        @foreach($recentPosts as $recentPost)
                                            <div class="ul-inner-sidebar-post">
                                                <div class="img">
                                                    <img src="{{ asset('storage/' . $recentPost->image) }}" alt="{{ $recentPost->title }}">
                                                </div>
                                                <div class="txt">
                                                    <h4 class="title">
                                                        <a href="{{ route('blog.detail', ['blog' => $recentPost->slug]) }}">{{ $recentPost->title }}</a>
                                                    </h4>
                                                    <span class="date">
                                                        <span>{{ $recentPost->created_at->format('M d, Y') }}</span>
                                                    </span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- single widget / Tags -->
                            <div class="ul-inner-sidebar-widget tags">
                                <h3 class="ul-inner-sidebar-widget-title">Tag Cloud</h3>
                                <div class="ul-inner-sidebar-widget-content">
                                    <div class="ul-inner-sidebar-tags">
                                        @foreach($tags as $tag)
                                            <a href="{{ route('blog', ['tag' => $tag->id]) }}">{{ $tag->name }}</a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- left/blog details -->
                    <div class="col-lg-8 col-md-7">
                        <div class="ul-blog-details ul-blog-inner mb-0">
                            <div class="ul-blog-2 ul-blog-inner">
                                <div class="ul-blog-img">
                                    <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}">
                                </div>
                                <div class="ul-blog-txt">
                                    <div class="ul-blog-infos">
                                        <!-- single info -->
                                        <div class="ul-blog-info">
                                            <span class="icon"><i class="flaticon-account"></i></span>
                                            <span class="text">By {{ $blog->author->name }}</span>
                                        </div>
                                        <!-- single info -->
                                        <div class="ul-blog-info">
                                            <span class="icon"><i class="flaticon-price-tag"></i></span>
                                            <span class="text">
                                                @foreach($blog->categories as $category)
                                                    {{ $category->name }}@if(!$loop->last), @endif
                                                @endforeach
                                            </span>
                                        </div>
                                    </div>
                                    <h2 class="ul-blog-title">{{ $blog->title }}</h2>
                                    <div class="ul-donation-details-summary-txt ul-blog-details-txt">
                                        {!! $blog->content !!}
                                    </div>
                                </div>
                            </div>

                            <!-- actions -->
                            <div class="ul-blog-details-actions">
                                <!-- tags -->
                                <div class="tags-wrapper">
                                    <h4 class="actions-title">Tags: </h4>
                                    <div class="ul-blog-sidebar-tags tags">
                                        @foreach($blog->tags as $tag)
                                            <a href="{{ route('blog', ['tag' => $tag->id]) }}">{{ $tag->name }}</a>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- share -->
                                <div class="shares-wrapper">
                                    <h4 class="actions-title">Share: </h4>
                                    <div class="share-options">
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog.detail', $blog->slug)) }}" target="_blank">
                                            <i class="flaticon-facebook"></i>
                                        </a>
                                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('blog.detail', $blog->slug)) }}&text={{ urlencode($blog->title) }}" target="_blank">
                                            <i class="flaticon-twitter"></i>
                                        </a>
                                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('blog.detail', $blog->slug)) }}&title={{ urlencode($blog->title) }}" target="_blank">
                                            <i class="flaticon-linkedin-big-logo"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                           {{--<div class="ul-blog-details-bottom">
                                <!-- reviews -->
                                <div class="ul-blog-details-reviews">
                                    <h3 class="ul-blog-details-inner-title ul-donation-details-summary-title">02 Comments</h3>

                                    <!-- single review -->
                                    <div class="ul-blog-details-review">
                                        <div class="main-comment">
                                            <!-- reviewer image -->
                                            <div class="ul-blog-details-review-reviewer-img">
                                                <img src="assets/img/commenter-1.jpg" alt="Reviewer Image">
                                            </div>

                                            <div class="ul-blog-details-review-txt">
                                                <p>Phasellus eget fermentum mauris. Suspendisse nec dignissim nulla. Integer non quam commodo, scelerisque felis id, eleifend turpis. Phasellus in nulla quis erat tempor tristique eget vel purus. Nulla pharetra pharetra pharetra. Praesent varius eget justo ut lacinia. Phasellus pharetra.</p>
                                                <div class="reviewer">
                                                    <h4 class="reviewer-name">Leslie Alexander</h4>
                                                    <h5 class="review-date">March 20, 2023 at 2:37 pm</h5>
                                                </div>
                                                <button class="ul-blog-details-review-reply-btn"><i class="flaticon-reply"></i> Reply</button>
                                            </div>
                                        </div>

                                        <div class="ul-blog-details-review-replies">
                                            <!-- single reply -->
                                            <div class="ul-blog-details-review-reply">
                                                <div class="main-comment">
                                                    <!-- reviewer image -->
                                                    <div class="ul-blog-details-review-reviewer-img">
                                                        <img src="assets/img/commenter-2.jpg" alt="Reviewer Image">
                                                    </div>

                                                    <div class="ul-blog-details-review-txt">
                                                        <p>Phasellus eget fermentum mauris. Suspendisse nec dignissim nulla. Integer non quam commodo, scelerisque felis id, eleifend turpis. Phasellus in nulla quis erat tempor tristique eget vel purus. Nulla pharetra pharetra pharetra. Praesent varius eget justo ut lacinia. Phasellus pharetra.</p>
                                                        <div class="reviewer">
                                                            <h4 class="reviewer-name">Leslie Alexander</h4>
                                                            <h5 class="review-date">March 20, 2023 at 2:37 pm</h5>
                                                        </div>
                                                        <button class="ul-blog-details-review-reply-btn"><i class="flaticon-reply"></i> Reply</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- review form -->
                                <div class="ul-blog-details-review-form-wrapper">
                                    <h3 class="ul-blog-details-inner-title ul-donation-details-summary-title">Leave a Comment</h3>
                                    <p>Your email address will not be published. Required fields are marked *</p>
                                    <form action="#" class="ul-contact-form ul-form">
                                        <div class="row row-cols-2 row-cols-xxs-1 ul-bs-row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <input type="text" name="name" id="ul-blog-comment-name" placeholder="Your Name">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <input type="email" name="email" id="ul-blog-comment-email" placeholder="Email Address">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <input type="text" name="subject" id="ul-blog-comment-subject" placeholder="Subject">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <textarea name="message" id="ul-blog-comment-msg" placeholder="Type your message"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <button class="ul-btn"><i class="flaticon-fast-forward-double-right-arrows-symbol"></i> Get in Touch</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        --}} 
                    </div>
                </div>
            </div>
        </div>
        <!-- BLOG SECTION END -->
  @endsection
