<!doctype html>
<html lang="en" data-layout="vertical" data-layout-style="" data-layout-position="fixed" data-topbar="dark">

<head>

    <meta charset="utf-8" />
    <title>{{ $page ." - ". get_config('site_name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ get_config('meta_description') }}" />
    <meta name="keywords" content="{{ get_config('meta_keyword') }}" />
    <meta name="author" content="RootWritter" />
    <meta name="theme-color" content="{{ get_config('meta_color') }}">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets') }}/images/favicon.ico">

    <!-- plugin css -->
    <link href="{{ asset('assets') }}/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />

    <!-- Layout config Js -->
    <script src="{{ asset('assets') }}/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="{{ asset('assets') }}/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets') }}/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets') }}/css/app.min.css" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{ asset('assets') }}/css/custom.min.css" rel="stylesheet" type="text/css" />
    <link href="https://rawcdn.githack.com/hung1001/font-awesome-pro/4cac1a6/css/all.css" rel="stylesheet" type="text/css" />
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <!-- Sweet Alert css-->
    <link href="{{ asset('assets') }}/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />

</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <header id="page-topbar">
            <div class="layout-width">
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box horizontal-logo">
                            <a href="{{ url('dashboard') }}" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="{{ asset('/') }}{{ get_config('logo') }}" alt="Logo {{ get_config('site_name') }}" style="height: 3.1rem;">
                                </span>
                                <span class="logo-lg">
                                    <img src="{{ asset('/') }}{{ get_config('logo') }}" alt="Logo {{ get_config('site_name') }}" style="height: 3.1rem;">
                                </span>
                            </a>

                            <a href="{{ url('dashboard') }}" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="{{ asset('/') }}{{ get_config('logo') }}" alt="Logo {{ get_config('site_name') }}" style="height: 3.1rem;">
                                </span>
                                <span class="logo-lg">
                                    <img src="{{ asset('/') }}{{ get_config('logo') }}" alt="Logo {{ get_config('site_name') }}" style="height: 3.1rem;">
                                </span>
                            </a>
                        </div>

                        <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
                            <span class="hamburger-icon">
                                <span></span>
                                <span></span>
                                <span></span>
                            </span>
                        </button>
                    </div>
                    <div class="d-flex align-items-center">
                        @if(auth()->user())
                        <div class="dropdown topbar-head-dropdown ms-1 header-item">
                            <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class='bx bx-category-alt fs-22'></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg p-0 dropdown-menu-end">
                                <div class="p-3 border-top-0 border-start-0 border-end-0 border-dashed border">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="m-0 fw-semibold fs-15"> Akses Cepat </h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-2">
                                    <div class="row g-0">
                                        <div class="col">
                                            <a class="dropdown-icon-item" href="#!">
                                                <i class="fal fa-cart-plus fa-2x text-info"></i>
                                                <span>Pesanan Baru</span>
                                            </a>
                                        </div>
                                        <div class="col">
                                            <a class="dropdown-icon-item" href="#!">
                                                <i class="fal fa-credit-card fa-2x text-success"></i>
                                                <span>Deposit Baru</span>
                                            </a>
                                        </div>
                                        <div class="col">
                                            <a class="dropdown-icon-item" href="#!">
                                                <i class="fal fa-tags fa-2x text-warning"></i>
                                                <span>Daftar Harga</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown ms-sm-3 header-item topbar-user">
                            <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="d-flex align-items-center">
                                    <img class="rounded-circle header-profile-user" src="{{ asset('assets') }}/images/users/avatar-1.jpg" alt="Header Avatar">
                                    <span class="text-start ms-xl-2">
                                        <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ userLogin()['user']['name'] }}</span>
                                        <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">{{ userLogin()['role'] }}</span>
                                    </span>
                                </span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <h6 class="dropdown-header">Selamat Datang {{ userLogin()['user']['name'] }}!</h6>
                                <a class="dropdown-item" href="{{ url('user/settings') }}"><i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Pengaturan Akun</span></a>
                                <a class="dropdown-item" href="{{ url('auth/logout') }}"><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-key="t-logout">Keluar Aplikasi</span></a>
                            </div>
                        </div>
                        @else
                        <div class="dropdown ms-sm-3 header-item topbar-user">
                            <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="d-flex align-items-center">
                                    <img class="rounded-circle header-profile-user" src="{{ asset('assets') }}/images/users/avatar-1.jpg" alt="Header Avatar">
                                    <span class="text-start ms-xl-2">
                                        <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">Tamu</span>
                                    </span>
                                </span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <h6 class="dropdown-header">Selamat Datang Tamu!</h6>
                                <a class="dropdown-item" href="{{ url('auth/login') }}"><i class="fas fa-sign-in-alt text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Login</span></a>
                                <a class="dropdown-item" href="{{ url('auth/register') }}"><i class="fas fa-user-plus text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-key="t-logout">Daftar</span></a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </header>
        <!-- ========== App Menu ========== -->
        <div class="app-menu navbar-menu">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="{{ url('admin/dashboard') }}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset('/') }}{{ get_config('logo_dark') }}" alt="Logo {{ get_config('site_name') }}" style="height: 2.1rem;">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('/') }}{{ get_config('logo_dark') }}" alt="Logo {{ get_config('site_name') }}" style="height: 2.1rem;">
                    </span>
                </a>

                <a href="{{ url('admin/dashboard') }}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('/') }}{{ get_config('logo') }}" alt="Logo {{ get_config('site_name') }}" style="height: 2.1rem;">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('/') }}{{ get_config('logo') }}" alt="Logo {{ get_config('site_name') }}" style="height: 2.1rem;">
                    </span>
                </a>
                <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                    <i class="ri-record-circle-line"></i>
                </button>
            </div>
            <div id="scrollbar">
                <div class="container-fluid">
                    <div id="two-column-menu">
                    </div>
                    <ul class="navbar-nav" id="navbar-nav">
                        <li class="menu-title"><span>Menu</span></li>
                        @if(auth()->user())
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{ url('/dashboard') }}">
                                <i class="fal fa-home"></i> <span>Halaman Utama</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#sidebarOrders" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarOrders">
                                <i class="fal fa-shopping-cart"></i> <span>Pemesanan</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarOrders">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="{{ url('orders/social-single') }}" class="nav-link"> Satuan </a>
                                    </li>
                                    <!-- <li class="nav-item">
                                        <a href="{{ url('orders/social-mass') }}" class="nav-link"> Massal </a>
                                    </li> -->
                                    <li class="nav-item">
                                        <a href="{{ url('orders/history') }}" class="nav-link"> Riwayat </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('orders/request') }}" class="nav-link"> Riwayat Permintaan</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#sidebarDeposits" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDeposits">
                                <i class="fal fa-credit-card"></i> <span>Deposit</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarDeposits">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="{{ url('deposit/new') }}" class="nav-link"> Baru </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('deposit/history') }}" class="nav-link"> Riwayat </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{ url('/daftar-harga') }}">
                                <i class="fal fa-tags"></i> <span>Daftar Harga</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{ url('/api-docs') }}">
                                <i class="fal fa-code"></i> <span>API Dokumentasi</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{ url('/tickets') }}">
                                <i class="fal fa-paper-plane"></i> <span>Support Ticket</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{ url('/monitoring_services') }}">
                                <i class="fal fa-eye"></i> <span>Monitoring Layanan</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#sidebarLogs" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarLogs">
                                <i class="fal fa-file"></i> <span>Data Mutasi</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarLogs">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="{{ url('logs/login') }}" class="nav-link"> Riwayat Login </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('logs/mutasi') }}" class="nav-link"> Mutasi Saldo </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#sidebarPages" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarPages">
                                <i class="fal fa-info"></i> <span>Halaman</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarPages">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="{{ url('pages/contact-us') }}" class="nav-link"> Hubungi Kami </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('pages/terms-of-services') }}" class="nav-link"> Ketentuan Layanan </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('pages/privacy') }}" class="nav-link"> Kebijakan Pribadi </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('pages/about-us') }}" class="nav-link"> Tentang Kami </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        @else
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{ url('/') }}">
                                <i class="fas fa-home"></i> <span>Halaman Utama</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{ url('/auth/login') }}">
                                <i class="fas fa-sign-in-alt"></i> <span>Login</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{ url('/auth/register') }}">
                                <i class="fas fa-user-plus"></i> <span>Register</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{ url('/daftar-harga') }}">
                                <i class="fas fa-tags"></i> <span>Daftar Harga</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#sidebarLogs" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarLogs">
                                <i class="fas fa-file"></i> <span>Halaman</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarLogs">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="{{ url('pages/contact-us') }}" class="nav-link"> Hubungi Kami </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('pages/terms-of-services') }}" class="nav-link"> Ketentuan Layanan </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('pages/privacy') }}" class="nav-link"> Kebijakan Pribadi </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('pages/about-us') }}" class="nav-link"> Tentang Kami </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        @endif
                    </ul>
                </div>
                <!-- Sidebar -->
            </div>
        </div>
        <!-- Left Sidebar End -->
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">{{ $page }}</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    @yield('view')
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>
                                document.write(new Date().getFullYear())
                            </script> © {{ get_config('site_name') }}.
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                Dibuat dengan <i class="mdi mdi-heart text-danger"></i> by RootWritter
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->



    <!--start back-to-top-->
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->

    <!--preloader-->
    <div id="preloader">
        <div id="status">
            <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script src="{{ asset('assets') }}/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets') }}/libs/simplebar/simplebar.min.js"></script>
    <script src="{{ asset('assets') }}/libs/node-waves/waves.min.js"></script>
    <script src="{{ asset('assets') }}/libs/feather-icons/feather.min.js"></script>
    <script src="{{ asset('assets') }}/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="{{ asset('assets') }}/js/plugins.js"></script>
    <!-- App js -->
    <script src="{{ asset('assets') }}/js/app.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <!--datatable js-->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <!-- Sweet Alerts js -->
    <script src="{{ asset('assets') }}/libs/sweetalert2/sweetalert2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.1.3/axios.js"></script>
    <script>
        var token = "{{ csrf_token() }}";
    </script>
    @yield('script')
</body>

</html>