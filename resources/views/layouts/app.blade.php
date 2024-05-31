<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>CORK Admin Template - Password Recovery Login Page</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="{{ asset('backend_theme') }}/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend_theme') }}/assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend_theme') }}/assets/css/authentication/form-2.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link rel="{{ asset('backend_theme') }}/stylesheet" type="text/css"
        href="assets/css/forms/theme-checkbox-radio.css">
    <link rel="{{ asset('backend_theme') }}/stylesheet" type="text/css" href="assets/css/forms/switches.css">
</head>

<body class="form">

    @yield('content')
    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="{{ asset('backend_theme') }}/assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="{{ asset('backend_theme') }}/bootstrap/js/popper.min.js"></script>
    <script src="{{ asset('backend_theme') }}/bootstrap/js/bootstrap.min.js"></script>

    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <script src="{{ asset('backend_theme') }}/assets/js/authentication/form-2.js"></script>

</body>

</html>
