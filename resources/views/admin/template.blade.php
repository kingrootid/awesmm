<!doctype html>
<html lang="en">

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
    <!-- Sweet Alert-->
    <link href="{{ asset('assets') }}/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <!-- Bootstrap Css -->
    <link href="{{ asset('assets') }}/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets') }}/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets') }}/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/gh/hung1001/font-awesome-pro@4cac1a6/css/all.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" />
</head>


<body data-sidebar="dark">

    <!-- <body data-layout="horizontal"> -->

    <!-- Begin page -->
    <div id="layout-wrapper">
        <header id="page-topbar" class="isvertical-topbar">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box">
                        <a href="{{ url('admin') }}" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="{{ render_logo_small('dark') }}" alt="" height="40">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ render_logo('dark') }}" alt="" height="40">
                            </span>
                        </a>

                        <a href="{{ url('admin') }}" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="{{ render_logo_small('light') }}" alt="" height="40">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ render_logo('light') }}" alt="" height="40">
                            </span>
                        </a>
                    </div>

                    <button type="button" class="btn btn-sm px-3 font-size-16 header-item vertical-menu-btn topnav-hamburger">
                        <span class="hamburger-icon open">
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
                    </button>

                    <div class="d-none d-sm-block ms-3 align-self-center">
                        <h4 class="page-title">{{ $page }}</h4>
                    </div>

                </div>

                <div class="d-flex">
                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item user text-start d-flex align-items-center" id="page-header-user-dropdown-v" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="rounded-circle header-profile-user" src="{{ asset('assets') }}/images/users/avatar-1.jpg" alt="Header Avatar">
                        </button>
                        <div class="dropdown-menu dropdown-menu-end pt-0">
                            <div class="p-3 border-bottom">
                                <h6 class="mb-0">{{ $user['name'] }}</h6>
                                <p class="mb-0 font-size-11 text-muted">{{ $user['super_admin'] ? 'Super Admin' : 'Admin' }}</p>
                            </div>
                            <a class="dropdown-item" href="{{ url('admin/settings') }}">
                                <i class="mdi mdi-cog-outline text-muted font-size-16 align-middle me-1"></i>
                                <span class="align-middle">Settings</span>
                            </a>
                            <a class="dropdown-item" href="{{ url('admin/auth/logout') }}"><i class="mdi mdi-logout text-muted font-size-16 align-middle me-1"></i> <span class="align-middle">Logout</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- ========== Left Sidebar Start ========== -->
        <div class="vertical-menu">

            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="{{ url('admin') }}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ render_logo_small('dark') }}" alt="" height="40">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ render_logo('dark') }}" alt="" height="40">
                    </span>
                </a>

                <a href="{{ url('admin') }}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ render_logo_small('light') }}" alt="" height="40">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ render_logo('light') }}" alt="" height="40">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 header-item vertical-menu-btn topnav-hamburger">
                <span class="hamburger-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </button>

            <div data-simplebar class="sidebar-menu-scroll">

                <!--- Sidemenu -->
                <div id="sidebar-menu">
                    <!-- Left Menu Start -->
                    <ul class="metismenu list-unstyled" id="side-menu">
                        <li class="menu-title" data-key="t-menu">Menu</li>

                        <li>
                            <a href="{{ url('admin') }}">
                                <i style="min-width: 1.5rem; font-size: 20px;" class="icon nav-icon fas fa-home"></i>
                                <span class="menu-item" data-key="t-dashboards">Dashboard</span>
                            </a>
                        </li>

                        <li class="menu-title" data-key="t-services-area">Services Area</li>
                        <li>
                            <a href="{{ url('admin/order_social') }}">
                                <i style="min-width: 1.5rem; font-size: 20px;" class="icon nav-icon fas fa-history"></i>
                                <span class="menu-item" data-key="t-history-order">Orders</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('admin/order-request') }}">
                                <i style="min-width: 1.5rem; font-size: 20px;" class="icon nav-icon fas fa-hands-helping"></i>
                                <span class="menu-item" data-key="t-request-order">Order Request</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('admin/history_deposits') }}">
                                <i style="min-width: 1.5rem; font-size: 20px;" class="icon nav-icon fas fa-receipt"></i>
                                <span class="menu-item" data-key="t-deposits">Transaction</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('admin/services') }}">
                                <i style="min-width: 1.5rem; font-size: 20px;" class="icon nav-icon fas fa-database"></i>
                                <span class="menu-item" data-key="t-services">Services</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('admin/category') }}">
                                <i style="min-width: 1.5rem; font-size: 20px;" class="icon nav-icon fas fa-layer-group"></i>
                                <span class="menu-item" data-key="t-category">Category</span>
                            </a>
                        </li>
                        <li class="menu-title" data-key="t-support-area">Support Area</li>
                        <li>
                            <a href="{{ url('admin/tickets') }}">
                                <i style="min-width: 1.5rem; font-size: 20px;" class="icon nav-icon fas fa-paper-plane"></i>
                                <span class="menu-item" data-key="t-tickets">Tickets</span>
                            </a>
                        </li>
                        <li class="menu-title" data-key="t-support-area">Manage User</li>
                        <li>
                            <a href="{{ url('admin/users') }}">
                                <i style="min-width: 1.5rem; font-size: 20px;" class="icon nav-icon fas fa-users"></i>
                                <span class="menu-item" data-key="t-users">Users</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('admin/role') }}">
                                <i style="min-width: 1.5rem; font-size: 20px;" class="icon nav-icon fas fa-user-lock"></i>
                                <span class="menu-item" data-key="t-role">Role</span>
                            </a>
                        </li>
                        <li class="menu-title" data-key="t-support-area">Manage Website</li>
                        <li>
                            <a href="{{ url('admin/web-config') }}">
                                <i style="min-width: 1.5rem; font-size: 20px;" class="icon nav-icon fas fa-globe-asia"></i>
                                <span class="menu-item" data-key="t-web-config">Web Config</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('admin/provider') }}">
                                <i style="min-width: 1.5rem; font-size: 20px;" class="icon nav-icon fas fa-link"></i>
                                <span class="menu-item" data-key="t-provider">API Provider</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('admin/api-conf') }}">
                                <i style="min-width: 1.5rem; font-size: 20px;" class="icon nav-icon fas fa-random"></i>
                                <span class="menu-item" data-key="t-api-configuration">API Configuration</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('admin/method') }}">
                                <i style="min-width: 1.5rem; font-size: 20px;" class="icon nav-icon fas fa-blanket"></i>
                                <span class="menu-item" data-key="t-method-deposit">Payment Method</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('admin/news') }}">
                                <i style="min-width: 1.5rem; font-size: 20px;" class="icon nav-icon fas fa-info"></i>
                                <span class="menu-item" data-key="t-news">News</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('admin/pages') }}">
                                <i style="min-width: 1.5rem; font-size: 20px;" class="icon nav-icon fas fa-file"></i>
                                <span class="menu-item" data-key="t-pages">Pages</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- Sidebar -->

                <div class="p-3 px-4 sidebar-footer">
                    <p class="mb-1 main-title">
                        <script>
                            document.write(new Date().getFullYear())
                        </script> &copy; {{ get_config('site_name') }}.
                    </p>
                    <p class="mb-0">Design & Develop by RootWritter</p>
                </div>
            </div>
        </div>
        <!-- Left Sidebar End -->
        <header class="ishorizontal-topbar">
            <div class="topnav">
                <div class="container-fluid">
                    <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

                        <div class="collapse navbar-collapse" id="topnav-menu-content">
                            <ul class="navbar-nav">
                                <li class="menu-title" data-key="t-menu">Menu</li>

                                <li>
                                    <a href="{{ url('admin') }}">
                                        <i style="min-width: 1.5rem; font-size: 20px;" class="icon nav-icon fas fa-home"></i>
                                        <span class="menu-item" data-key="t-dashboards">Dashboard</span>
                                    </a>
                                </li>

                                <li class="menu-title" data-key="t-services-area">Services Area</li>
                                <li>
                                    <a href="{{ url('admin/order_social') }}">
                                        <i style="min-width: 1.5rem; font-size: 20px;" class="icon nav-icon fas fa-history"></i>
                                        <span class="menu-item" data-key="t-history-order">Orders</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('admin/order-request') }}">
                                        <i style="min-width: 1.5rem; font-size: 20px;" class="icon nav-icon fas fa-hands-helping"></i>
                                        <span class="menu-item" data-key="t-request-order">Order Request</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('admin/history_deposits') }}">
                                        <i style="min-width: 1.5rem; font-size: 20px;" class="icon nav-icon fas fa-receipt"></i>
                                        <span class="menu-item" data-key="t-deposits">Transaction</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('admin/services') }}">
                                        <i style="min-width: 1.5rem; font-size: 20px;" class="icon nav-icon fas fa-database"></i>
                                        <span class="menu-item" data-key="t-services">Services</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('admin/category') }}">
                                        <i style="min-width: 1.5rem; font-size: 20px;" class="icon nav-icon fas fa-layer-group"></i>
                                        <span class="menu-item" data-key="t-category">Category</span>
                                    </a>
                                </li>
                                <li class="menu-title" data-key="t-support-area">Support Area</li>
                                <li>
                                    <a href="{{ url('admin/tickets') }}">
                                        <i style="min-width: 1.5rem; font-size: 20px;" class="icon nav-icon fas fa-paper-plane"></i>
                                        <span class="menu-item" data-key="t-tickets">Tickets</span>
                                    </a>
                                </li>
                                <li class="menu-title" data-key="t-support-area">Manage User</li>
                                <li>
                                    <a href="{{ url('admin/users') }}">
                                        <i style="min-width: 1.5rem; font-size: 20px;" class="icon nav-icon fas fa-users"></i>
                                        <span class="menu-item" data-key="t-users">Users</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('admin/role') }}">
                                        <i style="min-width: 1.5rem; font-size: 20px;" class="icon nav-icon fas fa-user-lock"></i>
                                        <span class="menu-item" data-key="t-role">Role</span>
                                    </a>
                                </li>
                                <li class="menu-title" data-key="t-support-area">Manage Website</li>
                                <li>
                                    <a href="{{ url('admin/web-config') }}">
                                        <i style="min-width: 1.5rem; font-size: 20px;" class="icon nav-icon fas fa-globe-asia"></i>
                                        <span class="menu-item" data-key="t-web-config">Web Config</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('admin/provider') }}">
                                        <i style="min-width: 1.5rem; font-size: 20px;" class="icon nav-icon fas fa-link"></i>
                                        <span class="menu-item" data-key="t-provider">API Provider</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('admin/api-conf') }}">
                                        <i style="min-width: 1.5rem; font-size: 20px;" class="icon nav-icon fas fa-random"></i>
                                        <span class="menu-item" data-key="t-api-configuration">API Configuration</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('admin/method') }}">
                                        <i style="min-width: 1.5rem; font-size: 20px;" class="icon nav-icon fas fa-blanket"></i>
                                        <span class="menu-item" data-key="t-method-deposit">Payment Method</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('admin/news') }}">
                                        <i style="min-width: 1.5rem; font-size: 20px;" class="icon nav-icon fas fa-info"></i>
                                        <span class="menu-item" data-key="t-news">News</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('admin/pages') }}">
                                        <i style="min-width: 1.5rem; font-size: 20px;" class="icon nav-icon fas fa-file"></i>
                                        <span class="menu-item" data-key="t-pages">Pages</span>
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </header>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">
                    @yield('view')
                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <script>
                                document.write(new Date().getFullYear())
                            </script> &copy; Borex. Design & Develop by Themesbrand
                        </div>
                    </div>
                </div>
            </footer>

        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- JAVASCRIPT -->
    <script src="{{ asset('assets') }}/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets') }}/libs/metismenujs/metismenujs.min.js"></script>
    <script src="{{ asset('assets') }}/libs/simplebar/simplebar.min.js"></script>
    <script src="{{ asset('assets') }}/libs/eva-icons/eva.min.js"></script>

    <script src="{{ asset('assets') }}/js/app.js"></script>
    <!-- Sweet Alerts js -->
    <script src="{{ asset('assets') }}/libs/sweetalert2/sweetalert2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.6.1/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
    @yield('script')

</body>

</html>