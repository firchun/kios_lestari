@extends('layouts.frontend.app')

@section('content')
    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a>
                        <span>{{ $title ?? 'Semua produk' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="product-list">
            <div class="row justify-content-center">
                @foreach ($produk as $item)
                    <div class="col-lg-4 col-sm-6">
                        <div class="product-item">
                            <div class="pi-pic">
                                <img src="{{ $item->foto_produk == null ? asset('img/no-image.jpg') : Storage::url($item->foto_produk) }}"
                                    alt="">
                                {{-- <div class="sale">Sale</div> --}}
                                {{-- <div class="icon">
                                <i class="icon_heart_alt"></i>
                            </div> --}}
                                <ul>
                                    {{-- <li class="w-icon active"><a href="#"><i class="icon_bag_alt"></i></a></li> --}}
                                    <li class="quick-view"><a href="{{ url('/detail-produk', $item->id) }}">+ Detail
                                            Produk</a></li>
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
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
