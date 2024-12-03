<?php $rtl = config('locales.languages')[app()->getLocale()]['rtl_support'] == 'rtl' ? '-rtl' : ''; ?>
{{-- if there is no cookie yet then make it dark else check the cookie value --}}
<?php $dark = Cookie::get('theme') !== null ? (Cookie::get('theme') == 'dark' ? '-dark' : '') : ''; ?>

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir=<?php echo $rtl ? 'rtl' : ''; ?>>
{{-- <html lang="{{ str_replace('_', '-', app()->getLocale()) }}"> --}}

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Premium Multipurpose Admin & Dashboard Template" />
    <meta name="robots" content="all,follow">
    <meta name="author" content="Themesdesign" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> {{ __('panel.dashboard') }} | {{ config('app.name', 'Laravel') }} </title>

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

    <!-- Plugin css for this page -->
    {{-- <link rel="stylesheet" href="{{ asset('backend/vendors/flatpickr/flatpickr.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('backend/vendors/flatpickr/flatpickr' . $rtl . '.min.css') }}">
    <!-- End plugin css for this page -->

    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('backend/fonts/feather-font/css/iconfont.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/vendors/flag-icon-css/css/flag-icon.min.css') }}">
    <!-- endinject -->

    <!-- fontawesome icon  picker  -->
    {{-- <link href="{{ asset('backend/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet"> --}}
    <!-- FontAwesome CSS - loading as last, so it doesn't block rendering-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    {{-- Start plugin added  --}}
    {{-- Responsive fileInput --}}
    <link rel="stylesheet" href="{{ asset('backend/vendors/bootstrap-fileinput/css/fileinput.min.css') }}">

    {{-- select2 libs --}}
    <link rel="stylesheet" href="{{ asset('backend/vendors/select2/select2.min.css') }}">

    {{-- pickadate calling css --}}
    <link rel="stylesheet" href="{{ asset('backend/vendors/datepicker/themes/classic.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/vendors/datepicker/themes/classic.date.css') }}">
    <!-- fontawesome icon  picker  -->
    <link href="{{ asset('backend/vendors/fontawesomepicker/css/fontawesome-iconpicker.css') }}" rel="stylesheet">

    {{-- end plugin added  --}}



    <!-- Layout styles -->
    {{-- <link rel="stylesheet" href="{{ asset('backend/css/demo1/style.css') }}"> --}}
    <link href="<?php echo asset('backend/css/style' . $dark . $rtl . '.css'); ?>" id="app-style" rel="stylesheet" type="text/css">

    <link href="<?php echo asset('backend/css/custom' . $dark . $rtl . '.css'); ?>" id="custom-style" rel="stylesheet" type="text/css">

    <!-- End layout styles -->

    <link rel="shortcut icon" href="{{ asset('backend/images/favicon.png') }}" />

    @livewireStyles

    @yield('style')
</head>

<body class="sidebar-dark">
    <!-- Begin main-wrapper -->
    <div id="app" class="main-wrapper">
        <!-- start  sidebar -->
        @include('partial.backend.sidebar')
        <!-- end  sidebar -->

        <div class="page-wrapper">
            @include('partial.backend.navbar')
            <div class="page-content">
                @yield('content')
            </div>
            @include('partial.backend.footer')
        </div>
    </div>
    <!-- END main-wrapper -->

    <!-- core:js -->
    <script src="{{ asset('backend/vendors/core/core.js') }}"></script>
    <!-- endinject -->

    <!-- Plugin js for Tinymce -->
    <script src="{{ asset('backend/vendors/tinymce/tinymce.min.js') }}"></script>
    <!-- End plugin js for Tinymce -->

    <script>
        var tinymceLanguage = '{{ app()->getLocale() }}'; // Get the current locale from Laravel config
        var flatPickrLanguage = '{{ app()->getLocale() }}';
    </script>

    <!-- Custom js for the Tinymce -->
    <script src="{{ asset('backend/js/tinymce.js') }}"></script>
    <!-- End custom js for Tinymce -->

    <!--tinymce js for editor -->
    {{-- <script src="{{ asset('backend/js/pages/form-editor.js') }}"></script> --}}


    <!-- Plugin js for this page -->
    {{-- <script src="{{ asset('backend/vendors/flatpickr/flatpickr.min.js') }}"></script> --}}
    <script src="{{ asset('backend/vendors/flatpickr/flatpickr' . $rtl . '.min.js') }}"></script>
    <script src="{{ asset('backend/js/flatpickr.js') }}"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/ar.js"></script>
    <script src="{{ asset('backend/vendors/apexcharts/apexcharts.min.js') }}"></script>
    <!-- End plugin js for this page -->

    <!-- inject:js -->
    <script src="{{ asset('backend/vendors/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('backend/js/template.js') }}"></script>
    <!-- endinject -->


    {{-- Start added new  --}}

    <!-- Responsive fileInput js start -->
    <script src="{{ asset('backend/vendors/bootstrap-fileinput/js/plugins/piexif.min.js') }}"></script>
    <script src="{{ asset('backend/vendors/bootstrap-fileinput/js/plugins/sortable.min.js') }}"></script>
    <script src="{{ asset('backend/vendors/bootstrap-fileinput/js/fileinput.min.js') }}"></script>
    <script src="{{ asset('backend/vendors/bootstrap-fileinput/themes/fa5/theme.min.js') }}"></script>

    {{-- Call select2 plugin --}}
    <script src="{{ asset('backend/vendors/select2/select2.min.js') }}"></script>

    {{-- pickadate calling js --}}
    <script src="{{ asset('backend/vendors/datepicker/picker.js') }}"></script>
    <script src="{{ asset('backend/vendors/datepicker/picker.date.js') }}"></script>
    <script src="{{ asset('backend/vendors/datepicker/picker.time.js') }}"></script>
    {{-- Calling fontawesome icon picker   --}}
    <script src="{{ asset('backend/vendors/fontawesomepicker/js/fontawesome-iconpicker.js') }}"></script>





    {{-- End added new  --}}

    <!-- Custom js for this page -->
    {{-- <script src="{{ asset('backend/js/dashboard-light.js') }}"></script> --}}
    <!-- End custom js for this page -->
    <script src="<?php echo asset($dark != '' ? 'backend/js/dashboard-dark.js' : 'backend/js/dashboard-light.js'); ?>"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('backend/js/change-status.js') }}"></script>
    <script src="{{ asset('backend/js/custom.js') }}"></script>



    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });

        $(function() {
            $('.icon-picker').iconpicker();
        });
    </script>

    <script>
        //select2: code to search in data 
        function matchStart(params, data) {
            // If there are no search terms, return all of the data
            if ($.trim(params.term) === '') {
                return data;
            }

            // Skip if there is no 'children' property
            if (typeof data.children === 'undefined') {
                return null;
            }

            // `data.children` contains the actual options that we are matching against
            var filteredChildren = [];
            $.each(data.children, function(idx, child) {
                if (child.text.toUpperCase().indexOf(params.term.toUpperCase()) == 0) {
                    filteredChildren.push(child);
                }
            });

            // If we matched any of the timezone group's children, then set the matched children on the group
            // and return the group object
            if (filteredChildren.length) {
                var modifiedData = $.extend({}, data, true);
                modifiedData.children = filteredChildren;

                // You can return modified objects from here
                // This includes matching the `children` how you want in nested data sets
                return modifiedData;
            }

            // Return `null` if the term should not be displayed
            return null;
        }

        // select2 : .select2 : is  identifier used with element to be effected
        $(".select2").select2({
            tags: true,
            colseOnSelect: false,
            minimumResultsForSearch: Infinity,
            matcher: matchStart
        });
    </script>

    @livewireScripts
    @yield('script')


</body>

</html>
