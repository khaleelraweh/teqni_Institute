<?php $rtl = config('locales.languages')[app()->getLocale()]['rtl_support'] == 'rtl' ? '-rtl' : ''; ?>
{{-- if there is no cookie yet then make it dark else check the cookie value --}}
<?php $dark = Cookie::get('theme') !== null ? (Cookie::get('theme') == 'dark' ? '-dark' : '') : ''; ?>

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Premium Multipurpose Admin & Dashboard Template" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="all,follow">
    <meta name="author" content="khaleelRaweh" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> Login | {{ config('app.name', 'Laravel') }} - Admin & Dashboard Template </title>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <!-- End fonts -->

    <!-- core:css -->
    <link rel="stylesheet" href="{{ asset('backend/vendors/core/core.css') }}">
    <!-- endinject -->


    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('backend/fonts/feather-font/css/iconfont.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/vendors/flag-icon-css/css/flag-icon.min.css') }}">
    <!-- endinject -->

    <!-- Layout styles -->
    <link href="<?php echo asset('backend/css/style' . $dark . $rtl . '.css'); ?>" id="app-style" rel="stylesheet" type="text/css">
    <!-- End layout styles -->

    <link rel="shortcut icon" href="{{ asset('backend/images/favicon.png') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/custom' . $rtl . '.css') }}">

    @yield('style')
</head>

<body class="auth-body-bg">

    <div class="bg-overlay"></div>

    <div id="app" class="wrapper-page">

        <div class="container-fluid p-0">
            @yield('content')
        </div>

    </div>

    <!-- core:js -->
    <script src="{{ asset('backend/vendors/core/core.js') }}"></script>
    <!-- endinject -->

    <!-- inject:js -->
    <script src="{{ asset('backend/vendors/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('backend/js/template.js') }}"></script>
    <!-- endinject -->

    @yield('script')
</body>

</html>
