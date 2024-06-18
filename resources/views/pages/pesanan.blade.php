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
    <section class="shopping-cart spad">
        <div class="container">
            <h2 class="mb-3">{{ $title }}</h2>
            <div class="row">
                <div class="col-lg-12">
                    <div class="cart-table">
                        <table>
                            <thead>
                                <tr>

                                    <th>Nama Produk</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Pengantaran</th>
                                    <th><i class="ti-info"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pesanan as $item)
                                    <tr>

                                        <td class="cart-title first-row p-2">
                                            <h5><strong>{{ $item->produk->nama_produk }}</strong><br><small
                                                    class="text-primary">{{ $item->jenis }}</small>
                                            </h5>
                                            <small>{{ $item->status }}</small>
                                        </td>
                                        <td class="text-left">
                                            Harga : Rp {{ number_format($item->produk->harga_produk) }}
                                            <br>
                                            Total : <span class="text-danger">Rp
                                                {{ number_format($item->total_harga) }}</span>
                                        </td>
                                        <td class="qua-col first-row">
                                            <strong>{{ $item->jumlah }}</strong><br>
                                            <small>{{ $item->produk->satuan_produk }}</small>
                                        </td>
                                        <td class="text-left">
                                            <strong
                                                class="text-{{ $item->diantar == 1 ? 'primary' : 'danger' }}">{{ $item->diantar == 1 ? 'Diantar' : 'Tidak' }}</strong><br>
                                            @if ($item->diantar == 1)
                                                <strong>Penerima :</strong> {{ $item->nama_penerima }}<br>
                                                <strong>No. HP/WA :</strong> {{ $item->nomor_penerima }}<br>
                                                <strong>Alamat :</strong> {{ $item->alamat_pengantaran }}
                                            @endif
                                        </td>
                                        <td class="close-td first-row px-3">
                                            <a href="#" data-toggle="modal"
                                                data-target="#detailPesanan-{{ $item->id }}"
                                                class="btn btn-sm btn-outline-primary mb-2 btn-block"
                                                style="display:inline-block;border-radius:0px;">
                                                Detail</a><br>
                                            @if ($item->status == 'pesanan diproses')
                                                <a href="{{ route('pesanan.dibatalkan', $item->id) }}"
                                                    class="btn btn-sm btn-outline-danger btn-block"
                                                    style="display:inline-block; border-radius:0px;">
                                                    Batalkan</a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-3 text-mutted">Belum ada pesanan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center mt-4">
                            {{ $pesanan->links('vendor.pagination.bootstrap-4') }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- modal -->
        @foreach ($pesanan as $item)
            <div class="modal fade" id="detailPesanan-{{ $item->id }}" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            Detail Pesanan {{ $item->no_invoice }}
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-primary  show" role="alert">
                                Status : <strong>{{ $item->status }}</strong>
                            </div>
                            <table class="table table-sm">
                                <tr>
                                    <td>Produk</td>
                                    <td>:</td>
                                    <td>{{ $item->produk->nama_produk }}</td>
                                </tr>
                                <tr>
                                    <td>Jenis</td>
                                    <td>:</td>
                                    <td>{{ $item->jenis }}<br>
                                        @if ($item->jenis == 'pre-order')
                                            <small class="text-danger">*pesanan akan diprioritaskan jika stok
                                                tersedia</small>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Harga</td>
                                    <td>:</td>
                                    <td class="text-danger">Rp {{ number_format($item->produk->harga_produk) }}</td>
                                </tr>
                                <tr>
                                    <td>Jumlah dipesan</td>
                                    <td>:</td>
                                    <td>{{ $item->jumlah }} {{ $item->produk->satuan_produk }}</td>
                                </tr>
                                <tr>
                                    <td>Total Tagihan</td>
                                    <td>:</td>
                                    <td class="text-danger">Rp {{ number_format($item->total_harga) }}</td>
                                </tr>
                                <tr>
                                    <td>Pengantaran</td>
                                    <td>:</td>
                                    <td> <strong
                                            class="text-{{ $item->diantar == 1 ? 'primary' : 'danger' }}">{{ $item->diantar == 1 ? 'Diantar' : 'Tidak' }}</strong>
                                    </td>
                                </tr>
                            </table>
                            @if ($item->diantar == 1)
                                <strong>Detail Pengantaran : </strong>
                                <table class="table table-sm">
                                    <tr>
                                        <td>Penerima</td>
                                        <td>:</td>
                                        <td>{{ $item->nama_penerima }}</td>
                                    </tr>
                                    <tr>
                                        <td>No. HP/WA</td>
                                        <td>:</td>
                                        <td>{{ $item->nomor_penerima }}</td>
                                    </tr>
                                    <tr>
                                        <td>Alamat Pengantaran</td>
                                        <td>:</td>
                                        <td>{{ $item->alamat_pengantaran }}</td>
                                    </tr>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </section>
@endsection
