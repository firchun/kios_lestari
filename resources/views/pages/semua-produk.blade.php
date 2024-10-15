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
                                    alt="" style="width:100%; height:400px; object-fit:cover;">
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
                                <div class="d-flex justify-content-center align-items-center">
                                    @php
                                        $rating = App\Models\Rating::getRatingProduk($item->id);
                                        $maxRating = 5;
                                    @endphp
                                    @for ($i = 1; $i <= $maxRating; $i++)
                                        <i class="fa fa-star {{ $i <= $rating ? 'text-warning' : 'text-muted' }}"></i>
                                    @endfor
                                </div>
                                <a href="#" style="font-weight: bold;">
                                    <h4>{{ $item->nama_produk }}</h4>
                                </a>
                                <div class="product-price">
                                    @if ($item->diskon == 1)
                                        <del class="text-danger">Rp {{ number_format($item->harga_produk) }}</del><br>
                                        @php
                                            $diskon = ($item->harga_produk * $item->jumlah_diskon) / 100;
                                            $harga_setelah_diskon = $item->harga_produk - $diskon;
                                        @endphp
                                        Rp {{ number_format($harga_setelah_diskon) }}
                                    @else
                                        Rp {{ number_format($item->harga_produk) }}
                                    @endif
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
    @include('pages._instagram')
@endsection
