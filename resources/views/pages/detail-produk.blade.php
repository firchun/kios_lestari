@extends('layouts.frontend.app')

@section('content')
    <div class="breacrumb-section mb-3">
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
    <section class="container my-3">
        <div class="row mb-3">
            <div class="col-lg-4 col-md-6 mb-3 text-center">
                <img src="{{ $produk->foto_produk == null ? asset('img/no-image.jpg') : Storage::url($produk->foto_produk) }}"
                    alt="">
            </div>
            <div class="col-lg-8 col-md-6">
                <h2>{{ $produk->nama_produk }}</h2>
                <div class="row my-2">
                    <div class="col-4 d-flex">
                        <strong class="mr-3 text-danger">4,5</strong>
                        <div class="d-flex justify-content-center align-items-center">
                            <i class="fa fa-star text-warning"></i>
                            <i class="fa fa-star text-warning"></i>
                            <i class="fa fa-star text-warning"></i>
                            <i class="fa fa-star text-mutted"></i>
                            <i class="fa fa-star text-mutted"></i>
                        </div>
                    </div>
                    <div class="col-4">
                        <strong class="text-danger">0</strong> Penilaian
                    </div>
                    <div class="col-4">
                        <strong class="text-danger">0</strong> <small>{{ $produk->satuan_produk }} </small> Terjual
                    </div>
                </div>
                <hr>
                <div class="my-2">
                    <span class="text-danger  h3" style="font-weight: bolder;">Rp
                        {{ number_format($produk->harga_produk) }}</span> <span>/{{ $produk->satuan_produk }}</span>
                </div>
                <strong>Keterangan Produk : </strong>
                <p>{{ $produk->keterangan_produk }}</p>
                <strong>Stok : </strong>
                <p>{!! App\Models\Stok::getStok($produk->id) > 0
                    ? '<strong class="text-primary">Tersedia ' .
                        App\Models\Stok::getStok($produk->id) .
                        '</strong> ' .
                        $produk->satuan_produk
                    : '<strong class="text-danger">Habis</strong>' !!}
                    <br>
                    @if (App\Models\Stok::getStok($produk->id) == 0)
                        <small class="text-mutted"><i>
                                barang telah habis / ingin memesan melebihi stok yang tersedia, anda dapat melakukan
                                pemesanan
                                terlebih dahulu
                                (pre-order)</i></small>
                    @endif
                </p>
                @guest
                    <a href="{{ route('login') }}" class="btn primary-btn">Login Sekarang </a>
                @else
                    <button type="submit" class=" btn primary-btn" data-toggle="modal" data-target="#modalPemesanan">Pesan
                        Sekarang</button>
                @endguest
            </div>
        </div>
        <hr>

        <div class="mb-3 border p-3">
            <strong>Rating dan Ulasan pelanggan</strong>
            <hr>
            <p class="text-muted">Belum ada rating dan ulasan dari pelanggan</p>
        </div>
    </section>
    <!-- modal -->
    <div class="modal fade" id="modalPemesanan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-body">
                    <form action="{{ route('pesanan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id_user" value="{{ Auth::id() }}">
                        <input type="hidden" name="id_produk" value="{{ $produk->id }}">
                        <strong>Buat Pesanan : {{ $produk->nama_produk }}</strong>
                        <hr>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label> Jumlah Dipesan : &nbsp; &nbsp;</label>
                                    <input type="number" class="form-control" name="jumlah" value="1">
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3 ">
                                    <label> Pengantaran : &nbsp; &nbsp;</label>
                                    <select class="form-control" name="diantar">
                                        <option value="0" selected>Tidak</option>
                                        <option value="1">Diantar</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <strong>Detail Pengantaran (diisi jika diantar)</strong>
                        <div class="m-2 p-2 border bg-light" style="border-radius: 20px;">
                            <div class="mb-3">
                                <label> Nama Penerima</label>
                                <input type="text" class="form-control" name="nama_penerima" placeholder="Nama Penerima">
                            </div>
                            <div class="mb-3">
                                <label> Nomor HP/WA Penerima (gunakan awalan +62)</label>
                                <input type="text" class="form-control" name="nomor_penerima"
                                    placeholder="+628xxxxxxxxxx">
                            </div>
                            <div class="mb-3">
                                <label> Alamat Pengantaran</label>
                                <textarea class="form-control" name="alamat_pengantaran">-</textarea>
                            </div>
                        </div>
                        <hr>
                        <div class="text-center">
                            <button type="button" class="btn btn-lg btn-danger" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn primary-btn">Pesan Sekarang</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
