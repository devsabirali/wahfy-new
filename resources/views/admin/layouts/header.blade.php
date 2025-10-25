 <!-- app-Header -->
            <div class="app-header header sticky">
                <div class="container-fluid main-container">
                    <div class="d-flex">
                        <a aria-label="Hide Sidebar" class="app-sidebar__toggle" data-bs-toggle="sidebar" href="javascript:void(0)"></a>
                        <!-- sidebar-toggle-->
                        <a class="logo-horizontal" href="{{ route('admin.dashboard') }}">
                            <img src="{{ Storage::url(get_logo()) }}" class="header-brand-img desktop-logo" alt="logo">
                            <img src="{{ Storage::url(get_logo()) }}" class="header-brand-img light-logo1"
                                alt="logo">
                        </a>
                        <!-- LOGO -->
                        <div class="main-header-center ms-3 d-none d-lg-block">
                            <input type="text" class="form-control" id="typehead" placeholder="Search for results...">
                            <button class="btn px-0 pt-2"><i class="fe fe-search" aria-hidden="true"></i></button>
                        </div>
                        <div class="d-flex order-lg-2 ms-auto header-right-icons align-items-center">
                            <!-- Dark/Light Mode Toggle -->
                            <div class="d-flex">
                                <a class="nav-link icon theme-layout nav-link-bg layout-setting">
                                    <span class="dark-layout"><i class="fe fe-moon"></i></span>
                                    <span class="light-layout"><i class="fe fe-sun"></i></span>
                                </a>
                            </div>
                            <!-- Settings Icon -->
                            <div class="dropdown d-flex header-settings">
                                <a href="javascript:void(0);" class="nav-link icon"
                                    data-bs-toggle="sidebar-right" data-target=".sidebar-right">
                                    <i class="fe fe-align-right"></i>
                                </a>
                            </div>
                            <!-- User Profile Dropdown -->
                            <div class="dropdown d-flex profile-1">
                                <a href="javascript:void(0)" data-bs-toggle="dropdown" class="nav-link leading-none d-flex align-items-center">
                                    <img src="{{ asset('admin/images/users/21.jpg') }}" alt="profile-user"
                                        class="avatar profile-user brround cover-image">
                                    <span class="ms-2 d-none d-lg-block">
                                        <span class="fw-semibold">{{ Auth::user()->name }}</span>
                                        <br>
                                        <small class="text-muted">{{ Auth::user()->email }}</small>
                                    </span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="dropdown-icon fe fe-alert-circle"></i> Sign out
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /app-Header -->
