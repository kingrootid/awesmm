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

</head>

<body>
    <div class="auth-page">
        <div class="container-fluid p-0">
            <div class="row g-0 align-items-center">
                <div class="col-md-6 m-auto">
                    <div class="row justify-content-center g-0">
                        <div class="col-md-6">
                            <div class="p-4">
                                <div class="card mb-0">
                                    <div class="card-body">
                                        <div class="auth-full-page-content rounded d-flex p-3 my-2">
                                            <div class="w-100">
                                                <div class="d-flex flex-column h-100">
                                                    <div class="mb-4 mb-md-5">
                                                        <a href="index.html" class="d-block auth-logo">
                                                            <img src="{{ render_logo('dark') }}" alt="" height="40" class="auth-logo-dark me-start">
                                                            <img src="{{ render_logo('light') }}" alt="" height="40" class="auth-logo-light me-start">
                                                        </a>
                                                    </div>
                                                    <div class="auth-content my-auto">
                                                        <div class="text-center">
                                                            <h5 class="mb-0">Welcome Back !</h5>
                                                            <p class="text-muted mt-2">Please Signin With your admin credential.</p>
                                                        </div>
                                                        <form class="mt-4 pt-2" method="POST" id="login">
                                                            <div class="form-floating form-floating-custom mb-4">
                                                                <input type="text" class="form-control" id="input-username" name="email" placeholder="Enter Email">
                                                                <label for="input-username">Email</label>
                                                                <div class="form-floating-icon">
                                                                    <i data-eva="people-outline"></i>
                                                                </div>
                                                            </div>

                                                            <div class="form-floating form-floating-custom mb-4 auth-pass-inputgroup">
                                                                <input type="password" class="form-control pe-5" id="password-input" name="password" placeholder="Enter Password">

                                                                <button type="button" class="btn btn-link position-absolute h-100 end-0 top-0" id="password-addon">
                                                                    <i class="mdi mdi-eye-outline font-size-18 text-muted"></i>
                                                                </button>
                                                                <label for="password-input">Password</label>
                                                                <div class="form-floating-icon">
                                                                    <i data-eva="lock-outline"></i>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Log In</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="mt-4 text-center">
                                                        <p class="mb-0">© <script>
                                                                document.write(new Date().getFullYear())
                                                            </script> {{ get_config('site_name') }} . Crafted with <i class="mdi mdi-heart text-danger"></i> by RootWritter</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end auth full page content -->
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container fluid -->
    </div>

    <!-- JAVASCRIPT -->
    <script src="{{ asset('assets') }}/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets') }}/libs/metismenujs/metismenujs.min.js"></script>
    <script src="{{ asset('assets') }}/libs/simplebar/simplebar.min.js"></script>
    <script src="{{ asset('assets') }}/libs/eva-icons/eva.min.js"></script>

    <script src="{{ asset('assets') }}/js/pages/eva-icon.init.js"></script>
    <!-- Sweet Alerts js -->
    <script src="{{ asset('assets') }}/libs/sweetalert2/sweetalert2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.6.1/axios.min.js"></script>
    <script>
        $("#login").submit(function(e) {
            e.preventDefault();
            $("#btn_login").attr('disabled', true);
            $("#btn_login").html(`<i class="fas fa-spinner fa-spin"></i> Please Wait...`)
            let form = new FormData(this);
            axios.post("{{ url('admin/auth/login') }}", form)
                .then(response => {
                    if (response.data.status) {
                        Swal.fire({
                            text: response.data.message,
                            icon: 'success',
                            buttonsStyling: false,
                            confirmButtonText: 'Continue!',
                            customClass: {
                                confirmButton: 'btn font-weight-bold btn-primary',
                            },
                        }).then(function(callback) {
                            if (callback.isConfirmed) {
                                window.location.href = "{{ url('admin/dashboard') }}"
                            }
                        });
                    } else {
                        Swal.fire({
                            text: response.data.message,
                            icon: 'error',
                            buttonsStyling: false,
                            confirmButtonText: 'Ok lets check',
                            customClass: {
                                confirmButton: 'btn font-weight-bold btn-danger',
                            },
                        });
                    }
                    $("#btn_login").attr('disabled', false);
                    $("#btn_login").html(`Login`)
                })
                .catch(error => {
                    Swal.fire({
                        text: error.response.data.message,
                        icon: 'error',
                        buttonsStyling: false,
                        confirmButtonText: 'Ok lets check',
                        customClass: {
                            confirmButton: 'btn font-weight-bold btn-danger',
                        },
                    });
                    $("#btn_login").attr('disabled', false);
                    $("#btn_login").html(`Login`)
                });

        })
    </script>

</body>

</html>