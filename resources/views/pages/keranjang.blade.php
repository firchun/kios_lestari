@extends('layouts.frontend.app')

@section('content')
    <div class="breacrumb-section mb-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a>
                        <span>{{ $title ?? 'Keranjang' }}</span>
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
                                    <th>No</th>
                                    <th>Nama Produk</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th><i class="ti-info"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($keranjang as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
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
                                                {{ number_format($item->produk->harga_produk * $item->jumlah) }}</span>
                                        </td>
                                        <td class="qua-col first-row">
                                            <strong>{{ $item->jumlah }}</strong><br>
                                            <small>{{ $item->produk->satuan_produk }}</small>
                                        </td>

                                        <td class="close-td first-row px-3">
                                            <a href="#" data-toggle="modal"
                                                data-target="#detailPesanan-{{ $item->id }}"
                                                class="btn btn-sm btn-outline-primary mb-2 btn-block"
                                                style="display:inline-block;border-radius:0px;">
                                                Pesan</a><br>
                                            <form action="{{ route('keranjang.delete', $item->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger btn-block"
                                                    style="display:inline-block; border-radius:0px;">
                                                    Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-3 text-mutted">Keranjang anda belum terisi
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center mt-4">
                            {{ $keranjang->links('vendor.pagination.bootstrap-4') }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- modal -->
        @foreach ($keranjang as $item)
            <div class="modal fade" id="detailPesanan-{{ $item->id }}" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            Buat Pesanan : {{ $item->produk->nama_produk }}
                        </div>
                        <form action="{{ route('pesanan.store') }}" method="POST">
                            <input type="hidden" name="id_user" value="{{ Auth::id() }}">
                            <input type="hidden" name="id_produk" value="{{ $item->id_produk }}">
                            <input type="hidden" name="id_keranjang" value="{{ $item->id }}">
                            @csrf
                            <div class="modal-body">
                                <hr>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label> Jumlah Dipesan : &nbsp; &nbsp;</label>
                                            <input type="number" class="form-control" name="jumlah"
                                                value="{{ $item->jumlah }}">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3 ">
                                            <label> Pengantaran : &nbsp; &nbsp;</label>
                                            <select class="form-control" name="diantar" id="diantarSelect">
                                                <option value="0" selected>Tidak</option>
                                                <option value="1">Diantar</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="" id="pengantaranForm">
                                    <strong>Detail Pengantaran </strong>
                                    <div class="m-2 p-2 border bg-light" style="border-radius: 20px;">
                                        <div class="mb-3">
                                            <label> Nama Penerima</label>
                                            <input type="text" class="form-control" name="nama_penerima"
                                                placeholder="Nama Penerima">
                                        </div>
                                        <div class="mb-3">
                                            <label> Nomor HP/WA Penerima (gunakan awalan +62)</label>
                                            <input type="text" class="form-control" name="nomor_penerima"
                                                placeholder="+628xxxxxxxxxx">
                                        </div>
                                        <div class="mb-3">
                                            <label>Pilih area pengantaran</label>
                                            <select class="form-control" name="id_area">
                                                @foreach (App\Models\AreaPengantaran::all() as $item)
                                                    <option value="{{ $item->id }}">{{ $item->nama }} - Rp
                                                        {{ number_format($item->harga) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label> Alamat Pengantaran</label>
                                            <textarea class="form-control" name="alamat_pengantaran">-</textarea>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                                <div class="text-center">
                                    <button type="button" class="btn btn-lg btn-danger" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn primary-btn">Pesan Sekarang</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const diantarSelect = document.getElementById('diantarSelect');
            const pengantaranForm = document.getElementById('pengantaranForm');

            function togglePengantaranForm() {
                if (diantarSelect.value === '1') {
                    pengantaranForm.style.display = 'block';
                } else {
                    pengantaranForm.style.display = 'none';
                }
            }

            // Initial check on page load
            togglePengantaranForm();

            // Add event listener to dropdown
            diantarSelect.addEventListener('change', togglePengantaranForm);
        });
    </script>
@endsection
