<!DOCTYPE html>
<html lang="zxx">

<head>

    <meta charset="UTF-8">
    <meta name="description" content="Fashi Template">
    <meta name="keywords" content="Fashi, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'Home' }} | {{ env('APP_NAME') ?? 'Laravel' }}</title>
    <!-- Site favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/') }}/logo.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/') }}/logo.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/') }}/logo.png" />
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="{{ asset('frontend_theme') }}/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="{{ asset('frontend_theme') }}/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="{{ asset('frontend_theme') }}/css/themify-icons.css" type="text/css">
    <link rel="stylesheet" href="{{ asset('frontend_theme') }}/css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="{{ asset('frontend_theme') }}/css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="{{ asset('frontend_theme') }}/css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="{{ asset('frontend_theme') }}/css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="{{ asset('frontend_theme') }}/css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="{{ asset('frontend_theme') }}/css/style.css" type="text/css">
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>
    @include('layouts.frontend.header')

    @yield('content')

    @include('layouts.frontend.footer')


    <!-- Js Plugins -->
    <script src="{{ asset('frontend_theme') }}/js/jquery-3.3.1.min.js"></script>
    <script src="{{ asset('frontend_theme') }}/js/bootstrap.min.js"></script>
    <script src="{{ asset('frontend_theme') }}/js/jquery-ui.min.js"></script>
    <script src="{{ asset('frontend_theme') }}/js/jquery.countdown.min.js"></script>
    <script src="{{ asset('frontend_theme') }}/js/jquery.nice-select.min.js"></script>
    <script src="{{ asset('frontend_theme') }}/js/jquery.zoom.min.js"></script>
    <script src="{{ asset('frontend_theme') }}/js/jquery.dd.min.js"></script>
    <script src="{{ asset('frontend_theme') }}/js/jquery.slicknav.js"></script>
    <script src="{{ asset('frontend_theme') }}/js/owl.carousel.min.js"></script>
    <script src="{{ asset('frontend_theme') }}/js/main.js"></script>
</body>

</html>
