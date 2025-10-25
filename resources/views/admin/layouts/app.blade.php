<!doctype html>
<html lang="en" dir="ltr">

<head>

    <!-- META DATA -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Wahfy Admin Panel – Manage donations, users, organizations, incidents, and more with the Wahfy admin dashboard.">
    <meta name="author" content="Wahfy Team">
    <meta name="keywords"
        content="wahfy, admin, dashboard, donations, user management, organization management, incident management, contributions, Laravel, responsive admin, wahfy admin panel, wahfy dashboard, charity, non-profit, management system, admin template, modern, ui kit, web app">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ Storage::url(get_favicon()) }}">

    <!-- BOOTSTRAP CSS -->
    <link id="style" href="{{asset('admin/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('admin/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('admin/css/plugins.css')}}" rel="stylesheet">
    <link href="{{asset('admin/css/icons.css')}}" rel="stylesheet">
    <link href="{{asset('admin/switcher/css/switcher.css')}}" rel="stylesheet">
    <link href="{{asset('admin/switcher/demo.css')}}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@6.5.95/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <!-- <link href="{{asset('admin/plugins/select2/select2.min.css')}}" rel="stylesheet"> -->
</head>

<body class="app sidebar-mini ltr light-mode">


    <!-- GLOBAL-LOADER -->
    {{-- <div id="global-loader">
        <img src="{{asset('admin/images/loader.svg')}}" class="loader-img" alt="Loader">
    </div> --}}
    <!-- /GLOBAL-LOADER -->

    <!-- PAGE -->
    <div class="page">
        <div class="page-main">

           {{-- Header --}}
           @include('admin.layouts.header')
           {{-- End Header --}}

            {{-- Sidebar --}}
            @include('admin.layouts.sidebar')
            {{-- End Sidebar --}}

            <!--Main Content-->
            <div class="main-content app-content mt-0">
                <div class="side-app">
                    <div class="main-container container-fluid" style="margin-top: 25px">
                        @yield('content')
                    </div>
                </div>
            </div>
            <!--End Main Content-->
        </div>


        <!-- Country-selector modal-->
        <div class="modal fade" id="country-selector">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content country-select-modal">
                    <div class="modal-header">
                        <h6 class="modal-title">Choose Country</h6><button aria-label="Close" class="btn-close"
                            data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <ul class="row p-3">
                            <li class="col-lg-6 mb-2">
                                <a href="javascript:void(0)" class="btn btn-country btn-lg btn-block active">
                                    <span class="country-selector"><img alt="" src="{{asset('admin/images/flags-img/us_flag.jpg')}}"
                                            class="me-3 language"></span>USA
                                </a>
                            </li>
                            <li class="col-lg-6 mb-2">
                                <a href="javascript:void(0)" class="btn btn-country btn-lg btn-block">
                                    <span class="country-selector"><img alt=""
                                        src="{{asset('admin/images/flags-img/italy_flag.jpg')}}"
                                        class="me-3 language"></span>Italy
                                </a>
                            </li>
                            <li class="col-lg-6 mb-2">
                                <a href="javascript:void(0)" class="btn btn-country btn-lg btn-block">
                                    <span class="country-selector"><img alt=""
                                        src="{{asset('admin/images/flags-img/spain_flag.jpg')}}"
                                        class="me-3 language"></span>Spain
                                </a>
                            </li>
                            <li class="col-lg-6 mb-2">
                                <a href="javascript:void(0)" class="btn btn-country btn-lg btn-block">
                                    <span class="country-selector"><img alt=""
                                        src="{{asset('admin/images/flags-img/india_flag.jpg')}}"
                                        class="me-3 language"></span>India
                                </a>
                            </li>
                            <li class="col-lg-6 mb-2">
                                <a href="javascript:void(0)" class="btn btn-country btn-lg btn-block">
                                    <span class="country-selector"><img alt=""
                                        src="{{asset('admin/images/flags-img/french_flag.jpg')}}"
                                        class="me-3 language"></span>French
                                </a>
                            </li>
                            <li class="col-lg-6 mb-2">
                                <a href="javascript:void(0)" class="btn btn-country btn-lg btn-block">
                                    <span class="country-selector"><img alt=""
                                        src="{{asset('admin/images/flags-img/russia_flag.jpg')}}"
                                        class="me-3 language"></span>Russia
                                </a>
                            </li>
                            <li class="col-lg-6 mb-2">
                                <a href="javascript:void(0)" class="btn btn-country btn-lg btn-block">
                                    <span class="country-selector"><img alt=""
                                        src="{{asset('admin/images/flags-img/germany_flag.jpg')}}"
                                        class="me-3 language"></span>Germany
                                </a>
                            </li>
                            <li class="col-lg-6 mb-2">
                                <a href="javascript:void(0)" class="btn btn-country btn-lg btn-block">
                                    <span class="country-selector"><img alt=""
                                        src="{{asset('admin/images/flags-img/argentina.jpg')}}"
                                        class="me-3 language"></span>Argentina
                                </a>
                            </li>
                            <li class="col-lg-6 mb-2">
                                <a href="javascript:void(0)" class="btn btn-country btn-lg btn-block">
                                    <span class="country-selector"><img alt="" src="{{asset('admin/images/flags-img/malaysia.jpg')}}"
                                        class="me-3 language"></span>Malaysia
                                </a>
                            </li>
                            <li class="col-lg-6 mb-2">
                                <a href="javascript:void(0)" class="btn btn-country btn-lg btn-block">
                                    <span class="country-selector"><img alt="" src="{{asset('admin/images/flags-img/turkey.jpg')}}"
                                        class="me-3 language"></span>Turkey
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Country-selector modal-->

        @include('admin.layouts.footer')
    <!-- BACK-TO-TOP -->
    <a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>


    <!-- JQUERY JS -->
    <script src="{{asset('admin/js/jquery.min.js')}}"></script>
    <script src="{{asset('admin/plugins/bootstrap/js/popper.min.js')}}"></script>
    <script src="{{asset('admin/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
    <!-- Select2 JS -->
    <script src="{{asset('admin/plugins/select2/select2.full.min.js')}}"></script>
    <script src="{{asset('admin/js/jquery.sparkline.min.js')}}"></script>
    <script src="{{asset('admin/js/sticky.js')}}"></script>
    <script src="{{asset('admin/js/circle-progress.min.js')}}"></script>
    <script src="{{asset('admin/plugins/peitychart/jquery.peity.min.js')}}"></script>
    <script src="{{asset('admin/plugins/peitychart/peitychart.init.js')}}"></script>
    <script src="{{asset('admin/plugins/sidebar/sidebar.js')}}"></script>
    <script src="{{asset('admin/plugins/p-scroll/perfect-scrollbar.js')}}"></script>
    <script src="{{asset('admin/plugins/p-scroll/pscroll.js')}}"></script>
    <script src="{{asset('admin/plugins/p-scroll/pscroll-1.js')}}"></script>
    <script src="{{asset('admin/plugins/chart/Chart.bundle.js')}}"></script>
    <script src="{{asset('admin/plugins/chart/utils.js')}}"></script>
    <script src="{{asset('admin/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('admin/plugins/datatable/js/dataTables.bootstrap5.js')}}"></script>
    <script src="{{asset('admin/plugins/datatable/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('admin/js/apexcharts.js')}}"></script>
    <script src="{{asset('admin/plugins/apexchart/irregular-data-series.js')}}"></script>
    <script src="{{asset('admin/plugins/flot/jquery.flot.js')}}"></script>
    <script src="{{asset('admin/plugins/flot/jquery.flot.fillbetween.js')}}"></script>
    <script src="{{asset('admin/plugins/flot/chart.flot.sampledata.js')}}"></script>
    <script src="{{asset('admin/plugins/flot/dashboard.sampledata.js')}}"></script>
    <script src="{{asset('admin/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js')}}"></script>
    <script src="{{asset('admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
    <script src="{{asset('admin/plugins/sidemenu/sidemenu.js')}}"></script>
	<script src="{{asset('admin/plugins/bootstrap5-typehead/autocomplete.js')}}"></script>
    <script src="{{asset('admin/js/typehead.js')}}"></script>
    <!-- <script src="{{asset('admin/js/index1.js')}}"></script> -->
    <script src="{{asset('admin/js/themeColors.js')}}"></script>
    <script src="{{asset('admin/js/custom.js')}}"></script>
    <script src="{{asset('admin/js/custom-swicher.js')}}"></script>
    <script src="{{asset('admin/switcher/js/switcher.js')}}"></script>

      @stack('scripts')
</body>

</html>
