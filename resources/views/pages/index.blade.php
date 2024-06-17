@extends('layouts.frontend.app')

@section('content')
    <!-- Hero Section Begin -->
    <section class="hero-section">
        <div class="hero-items owl-carousel">
            <div class="single-hero-items set-bg" data-setbg="{{ asset('frontend_theme') }}/img/hero-1.jpg">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-5">
                            <span>Bag,kids</span>
                            <h1>Batu Bata</h1>
                            <p>Batu Bata lokal terkenal dengan murahnya harga beli yang tentunya buatan lokal dari kampung
                                wasur, tentunya di buat dengan kualitas yang baik..</p>
                            <a href="{{ route('register') }}" class="primary-btn">Pesan Sekarang</a>
                        </div>
                    </div>

                </div>
            </div>
            <div class="single-hero-items set-bg" data-setbg="{{ asset('frontend_theme') }}/img/hero-2.jpg">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-5">
                            <span>Bag,kids</span>
                            <h1>Pasir</h1>
                            <p>Pasir merupakan komponen penting dalam pembangunan suatu bangunan baik tempat tinggal ataupun
                                bangunan lainnya, kami menyediakan pasir terbaik untuk anda</p>
                            <a href="{{ route('register') }}" class="primary-btn">Pesan Sekarang</a>
                        </div>
                    </div>
                    {{-- <div class="off-card">
                        <h2>Sale <span>50%</span></h2>
                    </div> --}}
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Banner Section Begin -->
    <div class="banner-section spad">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4">
                    <div class="single-banner">
                        <img src="{{ asset('frontend_theme') }}/img/banner-1.jpg" alt="">
                        <div class="inner-text">
                            <h4>Kayu Bakar</h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="single-banner">
                        <img src="{{ asset('frontend_theme') }}/img/banner-2.jpg" alt="">
                        <div class="inner-text">
                            <h4>Pasir</h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="single-banner">
                        <img src="{{ asset('frontend_theme') }}/img/banner-3.jpg" alt="">
                        <div class="inner-text">
                            <h4>Batu Bata</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Banner Section End -->

    <!-- Women Banner Section Begin -->
    <section class="women-banner spad">
        <div class="container-fluid">
            <div class="row">

                <div class="col-12">

                    <div class="product-slider owl-carousel">
                        @foreach ($produk as $item)
                            <div class="product-item">
                                <div class="pi-pic">
                                    <img src="{{ $item->foto_produk == null ? asset('img/logo.png') : Storage::url($item->foto_produk) }}"
                                        alt="">
                                    {{-- <div class="sale">Sale</div> --}}
                                    {{-- <div class="icon">
                                        <i class="icon_heart_alt"></i>
                                    </div> --}}
                                    <ul>
                                        <li class="w-icon active"><a href="#"><i class="icon_bag_alt"></i></a></li>
                                        <li class="quick-view"><a href="#">+ Detail Produk</a></li>
                                        {{-- <li class="w-icon"><a href="#"><i class="fa fa-random"></i></a></li> --}}
                                    </ul>
                                </div>
                                <div class="pi-text">
                                    <div
                                        class="catagory-name text-{{ App\Models\Stok::getStok($item->id) != 0 ? 'primary' : 'danger' }}">
                                        {{ App\Models\Stok::getStok($item->id) != 0 ? 'Tersedia' : 'Kosong' }}</div>
                                    <div class="d-flex justify-content-center mb-2">
                                        <i class="fa fa-star text-warning"></i>
                                        <i class="fa fa-star text-warning"></i>
                                        <i class="fa fa-star text-warning"></i>
                                        <i class="fa fa-star text-mutted"></i>
                                        <i class="fa fa-star text-mutted"></i>
                                    </div>
                                    <a href="#" style="font-weight: bold;">
                                        <h4>{{ $item->nama_produk }}</h4>
                                    </a>
                                    <div class="product-price">
                                        Rp {{ number_format($item->harga_produk) }}
                                        <small class="text-dark">/{{ $item->satuan_produk }}</small>
                                        {{-- <span>$35.00</span> --}}
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Women Banner Section End -->





    <!-- Instagram Section Begin -->
    <div class="instagram-photo">
        <div class="insta-item set-bg" data-setbg="{{ asset('frontend_theme') }}/img/insta-1.jpg">
            <div class="inside-text">
                <i class="ti-instagram"></i>
                <h5><a href="#">{{ env('APP_NAME') }}</a></h5>
            </div>
        </div>
        <div class="insta-item set-bg" data-setbg="{{ asset('frontend_theme') }}/img/insta-2.jpg">
            <div class="inside-text">
                <i class="ti-instagram"></i>
                <h5><a href="#">{{ env('APP_NAME') }}</a></h5>
            </div>
        </div>
        <div class="insta-item set-bg" data-setbg="{{ asset('frontend_theme') }}/img/insta-3.jpg">
            <div class="inside-text">
                <i class="ti-instagram"></i>
                <h5><a href="#">{{ env('APP_NAME') }}</a></h5>
            </div>
        </div>
        <div class="insta-item set-bg" data-setbg="{{ asset('frontend_theme') }}/img/insta-4.jpg">
            <div class="inside-text">
                <i class="ti-instagram"></i>
                <h5><a href="#">{{ env('APP_NAME') }}</a></h5>
            </div>
        </div>
        <div class="insta-item set-bg" data-setbg="{{ asset('frontend_theme') }}/img/insta-5.jpg">
            <div class="inside-text">
                <i class="ti-instagram"></i>
                <h5><a href="#">{{ env('APP_NAME') }}</a></h5>
            </div>
        </div>
        <div class="insta-item set-bg" data-setbg="{{ asset('frontend_theme') }}/img/insta-6.jpg">
            <div class="inside-text">
                <i class="ti-instagram"></i>
                <h5><a href="#">{{ env('APP_NAME') }}</a></h5>
            </div>
        </div>
    </div>
    <!-- Instagram Section End -->
@endsection
