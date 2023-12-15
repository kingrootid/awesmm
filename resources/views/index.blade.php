<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="light" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>{{$page ." - ". get_config('site_name')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ get_config('meta_description') }}" />
    <meta name="keywords" content="{{ get_config('meta_keyword') }}" />
    <meta name="author" content="RootWritter" />
    <meta name="theme-color" content="{{ get_config('meta_color') }}">
    <!-- Favicon icon -->
    <link rel="icon" href="{{asset('/')}}{{get_config('icon')}}" type="image/x-icon">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets') }}/images/favicon.ico">

    <!--Swiper slider css-->
    <link href="{{ asset('assets') }}/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />

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


</head>

<body data-bs-spy="scroll" data-bs-target="#navbar-example">

    <!-- Begin page -->
    <div class="layout-wrapper landing">
        <nav class="navbar navbar-expand-lg navbar-landing fixed-top" id="navbar">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{asset('/')}}{{get_config('logo')}}" class="card-logo card-logo-dark" alt="logo dark" height="38">
                </a>
                <button class="navbar-toggler py-0 fs-20 text-body" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="mdi mdi-menu"></i>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto mt-2 mt-lg-0" id="navbar-example">
                        <li class="nav-item">
                            <a class="nav-link fs-15" href="#hero">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fs-15" href="{{ url('daftar-harga') }}">Daftar Harga</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fs-15" href="{{ url('pages/contact-us') }}">Hubungi Kami</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fs-15" href="{{ url('pages/terms-of-services') }}">Kebijakan Layanan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fs-15" href="{{ url('pages/about-us') }}">Tentang Kami</a>
                        </li>
                    </ul>

                    <div class="">
                        <a href="{{ url('auth/login') }}" class="btn btn-link fw-medium text-decoration-none text-dark">Masuk</a>
                        <a href="{{ url('auth/register') }}" class="btn btn-primary">Daftar</a>
                    </div>
                </div>

            </div>
        </nav>
        <!-- end navbar -->

        <!-- start hero section -->
        <section class="section pb-0 hero-section" id="hero">
            <div class="bg-overlay bg-overlay-pattern"></div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-sm-10">
                        <div class="text-center mt-lg-5 pt-5">
                            <h1 class="display-6 fw-semibold mb-3 lh-base">Pilihan tepat untuk website <span class="text-success">Social Media Booster </span></h1>
                            <p class="lead text-muted lh-base">{{ get_config('site_name') }} Merupakan Website SMM Terlengkap, Termurah, Tercepat. Jaminan #1 Pusatnya Social Media Booster</p>

                            <div class="d-flex gap-2 justify-content-center mt-4">
                                <a href="{{ url('auth/login') }}" class="btn btn-primary">Masuk <i class="fas fa-sign-in-alt"></i></a>
                                <a href="{{ url('auth/register') }}" class="btn btn-danger">Daftar <i class="fas fa-user-plus"></i></a>
                            </div>
                        </div>

                        <div class="mt-4 mt-sm-5 pt-sm-5 mb-sm-n5 demo-carousel">
                            <div class="demo-img-patten-top d-none d-sm-block">
                                <img src="{{ asset('assets') }}/images/landing/img-pattern.png" class="d-block img-fluid" alt="...">
                            </div>
                            <div class="demo-img-patten-bottom d-none d-sm-block">
                                <img src="{{ asset('assets') }}/images/landing/img-pattern.png" class="d-block img-fluid" alt="...">
                            </div>
                            <div class="carousel slide carousel-fade" data-bs-ride="carousel">
                                <div class="carousel-inner shadow-lg p-2 bg-white rounded">
                                    <div class="carousel-item active" data-bs-interval="2000">
                                        <img src="{{ asset('assets') }}/images/demos/home.png" class="d-block w-100" alt="...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
            <div class="position-absolute start-0 end-0 bottom-0 hero-shape-svg">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
                    <g mask="url(&quot;#SvgjsMask1003&quot;)" fill="none">
                        <path d="M 0,118 C 288,98.6 1152,40.4 1440,21L1440 140L0 140z">
                        </path>
                    </g>
                </svg>
            </div>
            <!-- end shape -->
        </section>
        <!-- end hero section -->
        <!-- start counter -->
        <section class="py-5 position-relative bg-light" style="padding-top: 7rem!important">
            <div class="container">
                <div class="row text-center gy-4">
                    <div class="col-lg-4 col-12">
                        <div>
                            <h2 class="mb-2"><span>{{ thousandsCurrencyFormat($orderCounts*52712) }}</span>+</h2>
                            <div class="text-muted">Total Pesanan</div>
                        </div>
                    </div>
                    <!-- end col -->

                    <div class="col-lg-4 col-12">
                        <div>
                            <h2 class="mb-2"><span>{{ thousandsCurrencyFormat($userCounts*112) }}</span></h2>
                            <div class="text-muted">Total Pengguna Aktif</div>
                        </div>
                    </div>
                    <!-- end col -->

                    <div class="col-lg-4 col-12">
                        <div>
                            <h2 class="mb-2"><span>{{ thousandsCurrencyFormat($depositCounts*292) }}</span></h2>
                            <div class="text-muted">Total Deposit Selesai</div>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </section>
        <!-- end counter -->

        <!-- start services -->
        <section class="section" id="services">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="text-center mb-5">
                            <h1 class="mb-3 ff-secondary fw-semibold lh-base">Fitur</h1>
                            <p class="text-muted">Fitur Modern yang akan membuat anda lebih mudah</p>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->

                <div class="row g-3">
                    <div class="col-lg-4">
                        <div class="d-flex p-3">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar-sm icon-effect">
                                    <div class="avatar-title bg-transparent text-success rounded-circle">
                                        <i class="ri-pencil-ruler-2-line fs-36"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="fs-18">Creative Design</h5>
                                <p class="text-muted my-3 ff-secondary">Website yang dibuat interaktif, bertujuan untuk mempermudah anda dalam mengoperasikannya</p>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-lg-4">
                        <div class="d-flex p-3">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar-sm icon-effect">
                                    <div class="avatar-title bg-transparent text-success rounded-circle">
                                        <i class="ri-lightbulb-flash-line fs-36"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="fs-18">Meng"CUAN" Bersama Kami</h5>
                                <p class="text-muted my-3 ff-secondary">Anda bisa mendapatkan cuan dengan menjadi Reseller kami</p>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-lg-4">
                        <div class="d-flex p-3">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar-sm icon-effect">
                                    <div class="avatar-title bg-transparent text-success rounded-circle">
                                        <i class="ri-customer-service-line fs-36"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="fs-18">Support Handal</h5>
                                <p class="text-muted my-3 ff-secondary">Kami akan berusaha dapat membantu kebutuhan yang sedang anda cari untuk sosial media anda.</p>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-lg-4">
                        <div class="d-flex p-3">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar-sm icon-effect">
                                    <div class="avatar-title bg-transparent text-success rounded-circle">
                                        <i class="ri-settings-2-line fs-36"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="fs-18">Mudah digunakan</h5>
                                <p class="text-muted my-3 ff-secondary">Kami merancang website Se User Friendly mungkin.</p>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->

                    <div class="col-lg-4">
                        <div class="d-flex p-3">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar-sm icon-effect">
                                    <div class="avatar-title bg-transparent text-success rounded-circle">
                                        <i class="ri-slideshow-line fs-36"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="fs-18">Responsive & Clean Design</h5>
                                <p class="text-muted my-3 ff-secondary">Website kami mendukung semua perangkat Anda baik Smartphone, Tablet, Desktop, ataupun perangkat lainnya.</p>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-lg-4">
                        <div class="d-flex p-3">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar-sm icon-effect">
                                    <div class="avatar-title bg-transparent text-success rounded-circle">
                                        <i class="ri-briefcase-5-line fs-36"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="fs-18">Spesialist</h5>
                                <p class="text-muted my-3 ff-secondary">Kami sudah berdiri sejak 2016.</p>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </section>
        <!-- end services -->

        <!-- start faqs -->
        <section class="section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="text-center mb-5">
                            <h3 class="mb-3 fw-semibold">Pertanyaan yang sering muncul</h3>
                            <p class="text-muted mb-4 ff-secondary">Temukan jawabannya disini</p>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row g-lg-5 g-4">
                    <div class="col-lg-6 m-auto">
                        <div class="d-flex align-items-center mb-2">
                            <div class="flex-shrink-0 me-1">
                                <i class="ri-question-line fs-24 align-middle text-success me-1"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mb-0 fw-semibold">General Questions</h5>
                            </div>
                        </div>
                        <div class="accordion custom-accordionwithicon custom-accordion-border accordion-border-box" id="genques-accordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="genques-headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#genques-collapseOne" aria-expanded="true" aria-controls="genques-collapseOne">
                                        Apa itu {{ get_config('site_name') }} ?
                                    </button>
                                </h2>
                                <div id="genques-collapseOne" class="accordion-collapse collapse show" aria-labelledby="genques-headingOne" data-bs-parent="#genques-accordion">
                                    <div class="accordion-body ff-secondary">
                                        {{ get_config('site_name') }} adalah platform bisnis yang menyediakan berbagai layanan social media marketing yang bergerak terutama di Indonesia. Dengan bergabung bersama kami, Anda dapat menjadi penyedia jasa social media atau reseller social media seperti jasa penambah Followers, Likes, dll. Saat ini tersedia berbagai layanan untuk social media terpopuler seperti Instagram, Facebook, Twitter, Youtube, dll.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="genques-headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#genques-collapseTwo" aria-expanded="false" aria-controls="genques-collapseTwo">
                                        Bagaimana Cara Mendaftar ?
                                    </button>
                                </h2>
                                <div id="genques-collapseTwo" class="accordion-collapse collapse" aria-labelledby="genques-headingTwo" data-bs-parent="#genques-accordion">
                                    <div class="accordion-body ff-secondary">
                                        Anda dapat mendaftar secara gratis pada halaman pendaftaran. <a href="{{url('auth/register')}}">Klik Disini</a> untuk melakukan pendaftaran.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="genques-headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#genques-collapseThree" aria-expanded="false" aria-controls="genques-collapseThree">
                                        Bagaimana Cara Melakukan Pemesanan?
                                    </button>
                                </h2>
                                <div id="genques-collapseThree" class="accordion-collapse collapse" aria-labelledby="genques-headingThree" data-bs-parent="#genques-accordion">
                                    <div class="accordion-body ff-secondary">
                                        Untuk membuat pesanan sangatlah mudah, Anda hanya perlu masuk terlebih dahulu ke akun Anda dan menuju halaman pesanan dengan mengklik menu yang sudah tersedia.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="genques-headingFour">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#genques-collapseFour" aria-expanded="false" aria-controls="genques-collapseFour">
                                        Bagaimana cara isi saldo ?
                                    </button>
                                </h2>
                                <div id="genques-collapseFour" class="accordion-collapse collapse" aria-labelledby="genques-headingFour" data-bs-parent="#genques-accordion">
                                    <div class="accordion-body ff-secondary">
                                        Untuk melakukan deposit atau isi saldo sangatlah mudah, Anda hanya perlu masuk terlebih dahulu ke akun Anda dan menuju halaman deposit dengan mengklik menu yang sudah tersedia. Kami menyediakan deposit otomatis melalui bank, ewallet dan pulsa. Anda juga dapat deposit atau isi saldo secara manual dengan cara menghubungi salah satu tim kami.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end accordion-->

                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </section>
        <!-- end faqs -->

        <!-- Start footer -->
        <footer class="custom-footer bg-dark py-5 position-relative">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 mt-4">
                        <div>
                            <div>
                                <img src="{{asset('/')}}{{get_config('logo')}}" alt="logo light" height="38">
                            </div>
                            <div class=mt-4 fs-13">
                                <p>#1 World Social Media Marketing</p>
                                <p class="ff-secondary">World.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-7 ms-lg-auto">
                        <div class="row">
                            <div class="col-sm-6 mt-4">
                                <h5 class="text-white mb-0">Sitemap</h5>
                                <div class="text-muted mt-3">
                                    <ul class="list-unstyled ff-secondary footer-list fs-14">
                                        <li><a href="{{ url('sitemap/1') }}">Kontak</a></li>
                                        <li><a href="{{ url('sitemap/2') }}">Ketentuan Layanan</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-sm-6 mt-4">
                                <h5 class="text-white mb-0">Support</h5>
                                <div class="text-muted mt-3">
                                    <ul class="list-unstyled ff-secondary footer-list fs-14">
                                        <li><a href="https://wa.me/628185954820">Whatsapp</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row text-center text-sm-start align-items-center mt-5">
                    <div class="col-sm-6">

                        <div>
                            <p class="copy-rights mb-0">
                                <script>
                                    document.write(new Date().getFullYear())
                                </script> © {{ get_config('site_name') }} - RootWritter
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end footer -->

        <!--start back-to-top-->
        <button onclick="topFunction()" class="btn btn-danger btn-icon landing-back-top" id="back-to-top">
            <i class="ri-arrow-up-line"></i>
        </button>
        <!--end back-to-top-->

    </div>
    <!-- end layout wrapper -->


    <!-- JAVASCRIPT -->
    <script src="{{ asset('assets') }}/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets') }}/libs/simplebar/simplebar.min.js"></script>
    <script src="{{ asset('assets') }}/libs/node-waves/waves.min.js"></script>
    <script src="{{ asset('assets') }}/libs/feather-icons/feather.min.js"></script>
    <script src="{{ asset('assets') }}/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="{{ asset('assets') }}/js/plugins.js"></script>

    <!--Swiper slider js-->
    <script src="{{ asset('assets') }}/libs/swiper/swiper-bundle.min.js"></script>

    <!-- landing init -->
    <script src="{{ asset('assets') }}/js/pages/landing.init.js"></script>
</body>

</html>