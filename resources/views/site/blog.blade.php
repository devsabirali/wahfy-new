@extends('site.layouts.app')
@section('content')
        <!-- BREADCRUMBS SECTION START -->
        @include('site.layouts.breadcrumbs', [
            'title' => 'Blog',
            'items' => [
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'Blog']
            ]
        ])
        <!-- BREADCRUMBS SECTION END -->

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

                    <!-- left/blogs -->
                    <div class="col-lg-8 col-md-7">
                        <!-- blogs -->
                        <div>
                            @foreach($blogs as $blog)
                                <div class="ul-blog ul-blog-2 ul-blog-inner">
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
                                        <a href="{{ route('blog.detail', ['blog' => $blog->slug]) }}" class="ul-blog-title">{{ $blog->title }}</a>
                                        <p class="ul-blog-excerpt">{{ Str::limit($blog->description, 200) }}</p>
                                        <a href="{{ route('blog.detail', ['blog' => $blog->slug]) }}" class="ul-btn">
                                            <i class="flaticon-fast-forward-double-right-arrows-symbol"></i> Read More
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- pagination -->
                        <div class="ul-pagination">
                            {{ $blogs->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
