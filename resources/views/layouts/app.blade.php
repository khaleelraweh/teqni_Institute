<?php $rtl = config('locales.languages')[app()->getLocale()]['rtl_support'] == 'rtl' ? '-rtl' : ''; ?>
<?php $dark = Cookie::get('theme') !== null ? (Cookie::get('theme') == 'dark' ? 'dark' : '') : 'dark'; ?>
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="المعهد التقني العالى للعلوم الطبية">
    <meta name="robots" content="all,follow">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'المعهد التقني الطبي') }}</title>

    <!-- Google fonts-->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Libre+Franklin:wght@300;400;700&amp;display=swap">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Martel+Sans:wght@300;400;800&amp;display=swap">

    <!-- favicon -->
    <link rel="apple-touch-icon" href="apple-touch-icon.html">
    {{-- <link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend/images/fav-orange.png') }}"> --}}
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend/images/pre-logo-ibb.png') }}">
    <!-- Bootstrap v4.4.1 css -->
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/bootstrap.min.css') }}"> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/bootstrap' . $rtl . '.min.css') }}">
    <!-- font-awesome css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/font-awesome.min.css') }}">
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/fontawesome/fontawesome.css') }}"> --}}
    <!-- animate css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/animate.css') }}">
    <!-- owl.carousel css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/owl.carousel.css') }}">
    <!-- slick css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/slick.css') }}">
    <!-- off canvas css -->
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/off-canvas.css') }}"> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/off-canvas' . $rtl . '.css') }}">
    <!-- linea-font css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/fonts/linea-fonts.css') }}">
    <!-- flaticon css  -->
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/fonts/flaticon.css') }}">
    <!-- magnific popup css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/magnific-popup.css') }}">
    <!-- Main Menu css -->
    {{-- <link rel="stylesheet" href="{{ asset('frontend/css/rsmenu-main.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('frontend/css/rsmenu-main' . $rtl . '.css') }}">
    <!-- spacing css -->
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/rs-spacing.css') }}"> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/rs-spacing' . $rtl . '.css') }}">
    <!-- style css -->
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/style.css') }}"> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/style' . $rtl . '.css') }}">
    <!-- This stylesheet dynamically changed from style.less -->
    <!-- responsive css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/responsive' . $rtl . '.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/vendors/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/custom' . $rtl . '.css') }}">

    <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

    @livewireStyles
    @yield('style')

</head>
{{-- <body class="defult-home"> --}}

<body class="home-style2" dir="{{ $rtl == '-rtl' ? 'rtl' : 'ltr' }}">

    <!--Preloader area start here-->
    <div id="loader" class="loader">
        <div class="loader-container">
            <div class='loader-icon'>
                {{-- <img style="width: 90px;height:90px;" src="{{ asset('frontend/images/pre-logo-ibb.png') }}"
                    alt=""> --}}
                <img src="{{ asset('frontend/images/pre-logo-ibb.png') }}" alt="">
            </div>
        </div>
    </div>
    <!--Preloader area End here-->

    {{-- <body class="theme-forth"> for the pages.blade.php --}}
    <div id="app">
        <div class="main-content">
            <!-- navbar-->
            @include('partial.frontend.header')

            @yield('content')
        </div>


    </div>

    <!-- Footer -->
    @include('partial.frontend.footer')

    <!-- start scrollUp  -->
    <div id="scrollUp">
        <i class="fa fa-angle-up"></i>
    </div>
    <!-- End scrollUp  -->

    <!--  Modal -->
    @include('partial.frontend.modal')

    <!-- modernizr js -->
    <script src="{{ asset('frontend/js/modernizr-2.8.3.min.js') }}"></script>
    <!-- jquery latest version -->
    <script src="{{ asset('frontend/js/jquery.min.js') }}"></script>
    <!-- Bootstrap v4.4.1 js -->
    <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
    <!-- Menu js -->
    <script src="{{ asset('frontend/js/rsmenu-main.js') }}"></script>
    <!-- op nav js -->
    <script src="{{ asset('frontend/js/jquery.nav.js') }}"></script>
    <!-- owl.carousel js -->
    <script src="{{ asset('frontend/js/owl.carousel.min.js') }}"></script>
    <!-- Slick js -->
    <script src="{{ asset('frontend/js/slick.min.js') }}"></script>
    <!-- isotope.pkgd.min js -->
    <script src="{{ asset('frontend/js/isotope.pkgd.min.js') }}"></script>
    <!-- imagesloaded.pkgd.min js -->
    <script src="{{ asset('frontend/js/imagesloaded.pkgd.min.js') }}"></script>
    <!-- wow js -->
    <script src="{{ asset('frontend/js/wow.min.js') }}"></script>
    <!-- Skill bar js -->
    <script src="{{ asset('frontend/js/skill.bars.jquery.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.counterup.min.js') }}"></script>
    <!-- counter top js -->
    <script src="{{ asset('frontend/js/waypoints.min.js') }}"></script>
    <!-- video js -->
    <script src="{{ asset('frontend/js/jquery.mb.YTPlayer.min.js') }}"></script>
    <!-- magnific popup js -->
    <script src="{{ asset('frontend/js/jquery.magnific-popup.min.js') }}"></script>
    <!-- plugins js -->
    <script src="{{ asset('frontend/js/plugins.js') }}"></script>
    <!-- contact form js -->
    <script src="{{ asset('frontend/js/contact.form.js') }}"></script>
    <!-- main js -->
    {{-- <script src="{{ asset('frontend/js/main.js') }}"></script> --}}
    <script src="{{ asset('frontend/js/main' . $rtl . '.js') }}"></script>


    @livewireScripts
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <x-livewire-alert::scripts />
    @yield('script')

</body>

</html>
