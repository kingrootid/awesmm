<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>Basic Action | Velzon - Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets') }}/images/favicon.ico">

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

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

<body>
    <div class="row">
        <div class="col-12">
            <table class="body-wrap" style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: transparent; margin: 0;">
                <tr style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                    <td style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
                    <td class="container" width="600" style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">
                        <div class="content" style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
                            <table class="main" width="100%" cellpadding="0" cellspacing="0" itemprop="action" itemscope itemtype="http://schema.org/ConfirmAction" style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; margin: 0; border: none;">
                                <tr style="font-family: 'Roboto', sans-serif; font-size: 14px; margin: 0;">
                                    <td class="content-wrap" style="font-family: 'Roboto', sans-serif; box-sizing: border-box; color: #495057; font-size: 14px; vertical-align: top; margin: 0;padding: 30px; box-shadow: 0 3px 15px rgba(30,32,37,.06); ;border-radius: 7px; background-color: #fff;" valign="top">
                                        <meta itemprop="name" content="Confirm Email" style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;" />
                                        <table width="100%" cellpadding="0" cellspacing="0" style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                            <tr style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                                <td class="content-block" style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
                                                    <div style="text-align: center;margin-bottom: 15px;">
                                                        <img src="{{ asset('/') }}{{ get_config('logo_dark') }}" alt="" height="23">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                                <td class="content-block" style="font-family: 'Roboto', sans-serif; box-sizing: border-box; line-height: 1.5; font-size: 24px; vertical-align: top; margin: 0; padding: 0 0 10px;text-align: center; font-weight: 500;" valign="top">
                                                    Mohon Konfirmasi Email anda
                                                </td>
                                            </tr>
                                            <tr style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                                <td class="content-block" style="font-family: 'Roboto', sans-serif; color: #878a99; line-height: 1.5; box-sizing: border-box; font-size: 15px; vertical-align: top; margin: 0; padding: 0 0 24px; text-align: center;" valign="top">
                                                    Untuk dapat memasuki layanan {{ get_config('site_name') }}
                                                </td>
                                            </tr>
                                            <tr style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                                <td class="content-block" itemprop="handler" itemscope itemtype="http://schema.org/HttpActionHandler" style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 24px; text-align: center;" valign="top">
                                                    <a href="{{ url('auth/verify') }}/{{ $mailData->verifyCode }}" itemprop="url" style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: .8125rem;font-weight: 400; color: #FFF; text-decoration: none;text-align: center; cursor: pointer; display: inline-block; border-radius: .25rem; text-transform: capitalize; background-color: #0ab39c; margin: 0; border-color: #0ab39c; border-style: solid; border-width: 1px; padding: .5rem .9rem;" onMouseOver="this.style.background='#099885'" onMouseOut="this.style.background='#0ab39c'">Konfirmasi Akun Saya</a>
                                                </td>
                                            </tr>

                                            <tr style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0; border-top: 1px solid #e9ebec;">
                                                <td class="content-block" style="color: #878a99; text-align: center;font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0; padding-top: 15px" valign="top">
                                                    *jika tombol diatas tidak bisa diklik, copy dan paste URL dibawah ini ke browser anda. <br />
                                                    {{ url('auth/verify') }}/{{ $mailData->verifyCode }}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <div style="text-align: center; margin: 0px auto;">
                                <ul style="list-style: none;display: flex; justify-content: space-evenly; padding-top: 25px;margin-bottom: 20px; padding-left: 0px; font-family: 'Roboto', sans-serif;">
                                    <li>
                                        <a href="{{ url('pages/contact-us') }}" style="color: #495057;">Help Center</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('pages/terms-of-services') }}" style="color: #495057;">Ketentuan Layanan</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('pages/about-us') }}" style="color: #495057;">Tentang Kami</a>
                                    </li>
                                </ul>
                                <p style="font-family: 'Roboto', sans-serif; font-size: 14px;color: #98a6ad; margin: 0px;">2023 {{ get_config('site_name') }}. by RootWritter</p>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
            <!-- end table -->
        </div>
        <!--end col-->
    </div><!-- end row -->
</body>

</html>