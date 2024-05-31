<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>{{ env('APP_NAME') }} - {{ $title ?? '' }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('backend_theme') }}/assets/img/favicon.ico" />
    <link href="{{ asset('backend_theme') }}/assets/css/loader.css" rel="stylesheet" type="text/css" />
    <script src="{{ asset('backend_theme') }}/assets/js/loader.js"></script>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="{{ asset('backend_theme') }}/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend_theme') }}/assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend_theme') }}/assets/css/scrollspyNav.css" rel="stylesheet" type="text/css" />

    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <link href="{{ asset('backend_theme') }}/assets/css/dashboard/dash_1.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend_theme') }}/assets/css/elements/alert.css">
    <style>
        .btn-light {
            border-color: transparent;
        }
    </style>
    {{-- fonts --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.0/css/boxicons.min.css">
    {{-- datatable --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('backend_theme') }}/plugins/table/datatable/datatables.css">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('backend_theme') }}/plugins/table/datatable/dt-global_style.css">

    @stack('css')
</head>

<body class="sidebar-noneoverflow">
    <!-- BEGIN LOADER -->
    <div id="load_screen">
        <div class="loader">
            <div class="loader-content">
                <div class="spinner-grow align-self-center"></div>
            </div>
        </div>
    </div>
    <!--  END LOADER -->
    @include('layouts.backend.navbar')
    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>
        @include('layouts.backend.menu')
        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">
                <div class="layout-top-spacing">
                    @include('layouts.backend.alert')

                    @yield('content')
                </div>
            </div>

            @include('layouts.backend.footer')
        </div>
        <!--  END CONTENT AREA  -->
        <!-- / Menu -->
    </div>

    <!-- END MAIN CONTAINER -->

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->

    <script src="{{ asset('backend_theme') }}/assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="{{ asset('backend_theme') }}/bootstrap/js/popper.min.js"></script>
    <script src="{{ asset('backend_theme') }}/bootstrap/js/bootstrap.min.js"></script>
    <script src="{{ asset('backend_theme') }}/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="{{ asset('backend_theme') }}/assets/js/app.js"></script>
    <script>
        $(document).ready(function() {
            App.init();

        });
    </script>
    @stack('js')
    <script src="{{ asset('backend_theme') }}/assets/js/custom.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    <script src="{{ asset('backend_theme') }}/assets/js/scrollspyNav.js"></script>
    <script src="{{ asset('backend_theme') }}/assets/js/dashboard/dash_1.js"></script>
    <script src="{{ asset('backend_theme') }}/plugins/table/datatable/datatables.js"></script>
    <script src="{{ asset('backend_theme') }}/plugins/sweetalerts/sweetalert2.min.js"></script>
    <script src="{{ asset('backend_theme') }}/plugins/sweetalerts/custom-sweetalert.js"></script>
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->

    @if (Session::has('danger'))
        <script>
            swal({
                title: 'Error!',
                text: ' {{ Session::get('danger') }}',
                type: 'error',
                icon: 'error',
            })
        </script>
    @endif

    @if (Session::has('success'))
        <script>
            swal({
                title: 'Good job!',
                text: '{{ Session::get('success') }}',
                type: 'success',
            })
        </script>
    @endif
</body>

</html>
