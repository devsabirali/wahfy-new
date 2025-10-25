<div class="preloader" id="preloader">
    <div class="loader"></div>
</div>
<!-- SIDEBAR SECTION START -->
<div class="ul-sidebar">
    <!-- header -->
    <div class="ul-sidebar-header">
        <div class="ul-sidebar-header-logo">
            <a href="{{ route('home') }}">
                <img src="{{ Storage::url(get_logo()) }}" alt="logo" width="200px" class="logo">
            </a>
        </div>
        <!-- sidebar closer -->
        <button class="ul-sidebar-closer"><i class="flaticon-close"></i></button>
    </div>

    <div class="ul-sidebar-header-nav-wrapper d-block d-lg-none"></div>

    <!-- sidebar footer -->
    <div class="ul-sidebar-footer">
        <span class="ul-sidebar-footer-title">Follow us</span>
        <div class="ul-sidebar-footer-social">
            <a href="#"><i class="flaticon-facebook"></i></a>
            <a href="#"><i class="flaticon-twitter"></i></a>
            <a href="#"><i class="flaticon-instagram"></i></a>
            <a href="#"><i class="flaticon-youtube"></i></a>
        </div>
    </div>
</div>
<!-- SIDEBAR SECTION END -->

<!-- SEARCH MODAL SECTION START -->
<div class="ul-search-form-wrapper flex-grow-1 flex-shrink-0">
    <button class="ul-search-closer"><i class="flaticon-close"></i></button>
    <form action="{{ route('search') ?? '#' }}" method="GET" class="ul-search-form">
        <div class="ul-search-form-right">
            <input type="search" name="q" id="ul-search" placeholder="Search Here">
            <button type="submit"><span class="icon"><i class="flaticon-search"></i></span></button>
        </div>
    </form>
</div>
<!-- SEARCH MODAL SECTION END -->

<!-- HEADER SECTION START -->
<header class="ul-header ul-header-2">
    <div class="ul-header-top">
        <div class="ul-header-top-wrapper ul-header-container">
            <div class="ul-header-top-left">
                <span class="address"><i class="flaticon-pin"></i> {{ get_address() }}</span>
            </div>
            <div class="ul-header-top-right">
                <div class="ul-header-top-social">
                    @if (!Auth::check())
                        <div class="links" style="margin-right: 20px">
                            <a class="text-white" href="{{ route('login') }}">Login</a>
                            <a class="text-white" href="{{ route('register') }}">Register</a>
                        </div>
                    @else
                        <div class="links" style="margin-right: 20px">
                            @if(
                                auth()->user()->hasRole('admin') ||
                                auth()->user()->hasRole('super-admin') ||
                                auth()->user()->hasRole('indivisual-member') ||
                                auth()->user()->hasRole('family-leader') ||
                                auth()->user()->hasRole('group-leader') ||
                                auth()->user()->hasRole('member')
                            )
                                <a href="{{ route('admin.dashboard') }}" class="text-white" style="margin-right: 20px">Dashboard</a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="text-white">Logout</button>
                            </form>
                        </div>
                    @endif
                    <span class="title">Follow us: </span>
                    <div class="links">
                        <a href="#"><i class="flaticon-facebook"></i></a>
                        <a href="#"><i class="flaticon-twitter"></i></a>
                        <a href="#"><i class="flaticon-instagram"></i></a>
                        <a href="#"><i class="flaticon-youtube"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="ul-header-bottom to-be-sticky">
        <div class="ul-header-bottom-wrapper ul-header-container">
            <img src="{{ Storage::url(get_logo()) }}" alt="logo" width="200px" class="logo">
            <!-- header nav -->
            <div class="ul-header-nav-wrapper">
                <div class="to-go-to-sidebar-in-mobile">
                    <nav class="ul-header-nav">
                        <a href="{{ url('/') }}" >Home</a>
                        <a href="{{ route('about') }}">About</a>
                        <a href="{{ route('donation') }}" >Donations</a>
                        <a href="{{ route('gallery') }}" >Gallery</a>
                        <a href="{{ route('blog') }}" >Blog</a>
                        <a href="{{ route('contact') }}">Contact</a>
                    </nav>
                </div>
            </div>

            <!-- actions -->
            <div class="ul-header-actions">
                <button class="ul-header-search-opener"><i class="flaticon-search"></i></button>
                <a href="{{ route('contact') }}" class="ul-btn d-sm-inline-flex d-none">
                    <i class="flaticon-fast-forward-double-right-arrows-symbol"></i> Join With us
                </a>
                <button class="ul-header-sidebar-opener d-lg-none d-inline-flex">
                    <i class="flaticon-menu"></i>
                </button>
            </div>
        </div>
    </div>
</header>
<!-- HEADER SECTION END -->
