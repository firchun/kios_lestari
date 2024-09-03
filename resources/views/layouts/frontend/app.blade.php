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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
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
    <style>
        .chat-button {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 1050;
        }

        .chat-button .btn {
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            border-radius: 50%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.46);
        }

        .chat-button .btn:hover {
            background-color: #004692;
        }
    </style>

</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>
    @include('layouts.frontend.header')
    @if (Auth::check() && session('showModal'))
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                <div class="modal-content " style="border-radius: 20px;">
                    <div class="modal-header pb-0 text-center">
                        <b>
                            @if (App\Models\User::userPoint(Auth::id()) != 0)
                                HORE!!!
                            @else
                                ya...🥲
                            @endif
                        </b>
                        <button type="button" class="close mb-3" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        @if (App\Models\User::userPoint(Auth::id()) != 0)
                            <h1>🎉</h1>
                            <p>Hore, Point kamu udah <b
                                    class="text-danger">{{ App\Models\User::userPoint(Auth::id()) }}
                                    Point</b>..<br>Yuk
                                perbanyak point kamu dengan belanja di {{ env('APP_NAME') }}</p>
                            <a href="{{ url('/my-akun') }}" class="btn btn-outline-primary">Cek di sini</a>
                        @else
                            <h1>🥲</h1>
                            <p>
                                Kamu belum memiliki point, yuk belanja agar mendapatkan point..
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
    @yield('content')
    <!-- Tombol Chat -->
    <div class="chat-button">
        <a href="{{ route('chat-user') }}" class="btn btn-primary text-white">
            <i class="bi bi-chat-dots"></i>
        </a>
    </div>
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
    <!-- SweetAlert CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            @if (Auth::check() && session('showModal'))
                $('#exampleModal').modal('show');
                // Hapus session setelah menampilkan modal
                @php session()->forget('showModal'); @endphp
            @endif
        });
    </script>
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
            });
        </script>
    @endif
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
            });
        </script>
    @endif
</body>

</html>
