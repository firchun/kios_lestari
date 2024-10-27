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
                    {{-- <small class="text-danger">Klik Nomor invoice untuk melihat detail invoice</small> --}}
                    <div class="cart-table">
                        <table>
                            <thead>
                                <tr>

                                    <th>No</th>
                                    <th>Invoice</th>
                                    <th>Nama Produk</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Diantar</th>
                                    <th><i class="ti-info"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pesanan as $item)
                                    <tr>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>
                                            <a href=""
                                                class="text-black font-weight-bold">{{ $item->no_invoice }}</a>
                                        </td>
                                        <td class="cart-title first-row p-2">
                                            <h5><strong>{{ $item->produk->nama_produk }}</strong><br><small
                                                    class="text-primary">{{ $item->jenis }}</small>
                                            </h5>
                                            <small>{{ $item->status }}</small>
                                        </td>
                                        <td class="text-left">
                                            @if ($item->jumlah * $item->produk->harga_produk == $item->total_harga)
                                                Harga : Rp {{ number_format($item->produk->harga_produk) }}
                                            @else
                                                @php
                                                    $diskon =
                                                        ($item->produk->harga_produk * $item->produk->jumlah_diskon) /
                                                        100;
                                                    $harga_setelah_diskon = $item->produk->harga_produk - $diskon;
                                                @endphp
                                                Harga : Rp <del>{{ number_format($item->produk->harga_produk) }}</del>
                                                <span
                                                    class="text-primary">{{ number_format($harga_setelah_diskon) }}</span>
                                            @endif
                                            <br>
                                            Total : <span class="text-danger">Rp
                                                {{ number_format($item->total_harga) }}</span><br>
                                            Pembayaran :
                                            @php
                                                $check_pembayaran = App\Models\Pembayaran::where(
                                                    'id_pesanan',
                                                    $item->id,
                                                )
                                                    ->latest()
                                                    ->first();

                                            @endphp
                                            @if ($check_pembayaran)
                                                @if ($check_pembayaran->terverifikasi == 1)
                                                    <span class="text-success">Lunas</span>
                                                @elseif($check_pembayaran->terverifikasi == 2)
                                                    <span class="text-danger">Pembayaran ditolak</span>
                                                @else
                                                    <span class="text-danger">Menunggu Verifikasi</span>
                                                @endif
                                            @else
                                                <span class="text-danger">Belum
                                                    lunas</span>
                                            @endif

                                        </td>
                                        <td class="qua-col first-row">
                                            <strong>{{ $item->jumlah }}</strong><br>
                                            <small>{{ $item->produk->satuan_produk }}</small>
                                        </td>
                                        <td class="text-left">
                                            <strong
                                                class="text-{{ $item->diantar == 1 ? 'primary' : 'danger' }}">{{ $item->diantar == 1 ? 'Diantar' : 'Tidak' }}</strong><br>

                                        </td>
                                        <td class="close-td first-row px-3">
                                            <a href="#" data-toggle="modal"
                                                data-target="#detailPesanan-{{ $item->id }}"
                                                class="btn btn-sm btn-outline-primary mb-2 btn-block"
                                                style="display:inline-block;border-radius:0px;">
                                                Detail</a><br>

                                            @if (App\Models\Pembayaran::where('id_pesanan', $item->id)->where('terverifikasi', '!=', [2, 0])->count() == 0)
                                                <button type="button" class="btn btn-sm btn-outline-success btn-block"
                                                    style="display:inline-block; border-radius:0px;" data-toggle="modal"
                                                    data-target="#bayar-{{ $item->id }}">
                                                    Bayar</button>
                                            @endif
                                            @if ($item->status == 'pesanan diproses')
                                                <a href="{{ route('pesanan.dibatalkan', $item->id) }}"
                                                    class="btn btn-sm btn-outline-danger btn-block"
                                                    style="display:inline-block; border-radius:0px;">
                                                    Batalkan</a>
                                            @elseif($item->status == 'pesanan sampai di lokasi tujuan' || ($item->status = 'pesanan telah selesai'))
                                                @if (App\Models\Rating::where('id_pesanan', $item->id)->count() == 0)
                                                    <button type="button" class="btn btn-sm btn-warning btn-block"
                                                        style="display:inline-block; border-radius:0px;" data-toggle="modal"
                                                        data-target="#ulasan-{{ $item->id }}">
                                                        Beri Ulasan</button>
                                                @endif
                                                <a href="#" data-toggle="modal"
                                                    data-target="#return-{{ $item->id }}"
                                                    class="btn btn-sm btn-danger mb-2 btn-block"
                                                    style="display:inline-block;border-radius:0px;">
                                                    Return</a>
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
            @if (App\Models\Rating::where('id_pesanan', $item->id)->count() == 0)
                <div class="modal fade" id="ulasan-{{ $item->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                Beri ulasan pada : ({{ $item->no_invoice }})
                            </div>
                            <form action="{{ route('rating.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <input type="hidden" name="id_pesanan" value="{{ $item->id }}">
                                    <input type="hidden" name="id_produk" value="{{ $item->id_produk }}">

                                    <div class="mb-3">
                                        <label>Rating (1-5)</label>
                                        <input type="number" name="rating" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Ulasan anda pada produk ini</label>
                                        <textarea name="ulasan" class="form-control" required></textarea>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-warning">Upload </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
            @if (App\Models\Pembayaran::where('id_pesanan', $item->id)->where('terverifikasi', '!=', [2, 0])->count() == 0)
                <div class="modal fade" id="bayar-{{ $item->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                Upload Bukti Pembayaran : ({{ $item->no_invoice }})
                            </div>

                            <form action="{{ route('pembayaran.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="my-3">
                                        <div class="alert alert-primary alert-dismissible" role="alert">
                                            <strong> Cara pembayaran :</strong>
                                            <ol class="p-2">
                                                <li>Buka Mobile banking / pergi ke ATM terdekat</li>
                                                <li>Pilih transfer</li>
                                                <li>Isi nomor rekening tujuan</li>
                                                <li>ketik nominal transfer (Rp {{ number_format($item->total_harga) }})
                                                </li>
                                            </ol>
                                            <br>
                                            <strong> Daftar Rekening :</strong>
                                            <ul class="p-2">
                                                @foreach (App\Models\Bank::all() as $item)
                                                    <li><b>{{ $item->nama_bank }}</b> : {{ $item->nama_pemilik }}
                                                        ({{ $item->no_rekening }})
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    @if (App\Models\Pembayaran::where('id_pesanan', $item->id)->where('terverifikasi', 2)->count() != 0)
                                        <div class="my-3">
                                            <div class="alert alert-danger  show" role="alert">
                                                Mohon maaf, Pembayaran sebelumnya ditolak..<br> silahkan upload ulang bukti
                                                pembayaran anda..
                                            </div>
                                        </div>
                                    @endif
                                    <input type="hidden" name="id_pesanan" value="{{ $item->id }}">
                                    <div class="mb-3">
                                        <label>Jumlah Pembayaran (Rp)</label>
                                        <input type="number" name="jumlah" class="form-control"
                                            value="{{ $item->total_harga }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Foto bukti pembayaran</label>
                                        <input type="file" name="foto" class="form-control" required>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-warning">Upload </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
            @if ($item->status == 'pesanan sampai di lokasi tujuan' || $item->status == 'pesanan telah selesai')
                <div class="modal fade" id="return-{{ $item->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                Pengajuan Return : {{ $item->produk->nama_produk }} ({{ $item->no_invoice }})
                            </div>

                            @php
                                $return = App\Models\PengajuanReturn::where('id_pesanan', $item->id)
                                    ->latest()
                                    ->first();
                            @endphp
                            @if (!$return)
                                <form action="{{ route('return.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <input type="hidden" name="id_pesanan" value="{{ $item->id }}">
                                        <input type="hidden" name="jumlah" value="0">
                                        <div class="mb-3">
                                            <label>Foto bukti keruakan</label>
                                            <input type="file" name="foto" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Keterangan</label>
                                            <textarea name="keterangan" class="form-control" required></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-warning">Ajukan </button>
                                    </div>
                                </form>
                            @else
                                <div class="modal-body">
                                    @if ($return->disetujui == 1 && $return->selesai != 1)
                                        <div class="alert alert-primary  show" role="alert">
                                            Status : Pengajuan telah disetujui
                                        </div>
                                    @elseif($return->disetujui == 1 && $return->selesai == 1)
                                        <div class="alert alert-primary  show" role="alert">
                                            Status : Return telah selesai
                                        </div>
                                    @else
                                        <div class="alert alert-primary  show" role="alert">
                                            Status : Menunggu persetujuan
                                        </div>
                                    @endif
                                    <div class="mt-3 text-center">
                                        <img src="{{ Storage::url($return->foto) }}" alt="return"
                                            style="width: 150px; height:150px; object-fit:cover;">
                                        <p>
                                            Keterangan = {{ $return->keterangan }}
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
        {{-- {{ dd($pesanan) }} --}}
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
                                Status : <strong> {{ $item->status }}</strong>
                            </div>
                            @if (App\Models\Rating::where('id_pesanan', $item->id)->count() != 0)
                                <div class="alert alert-warning  show" role="alert">
                                    Terimakasih telah memberikan rating dan ulasan anda...<br>
                                    <div class="d-flex  align-items-center my-2">
                                        @php
                                            $ulasan = App\Models\Rating::where('id_pesanan', $item->id)->first()
                                                ->ulasan;
                                            $rating = App\Models\Rating::where('id_pesanan', $item->id)->first()
                                                ->rating;
                                            $maxRating = 5;
                                        @endphp

                                        @for ($i = 1; $i <= $maxRating; $i++)
                                            <i class="fa fa-star {{ $i <= $rating ? 'text-warning' : 'text-muted' }}"></i>
                                        @endfor
                                    </div>
                                    <p>
                                        Ulasan : " {{ $ulasan }} "
                                    </p>
                                </div>
                            @endif
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
                                @php
                                    $check_pembayaran = App\Models\Pembayaran::where('id_pesanan', $item->id)
                                        ->latest()
                                        ->first();

                                @endphp
                                @if ($check_pembayaran)
                                    <tr>
                                        <td>Bukti Pembayaran</td>
                                        <td>:</td>
                                        <td><a href="{{ Storage::url($check_pembayaran->foto) }}" target="__blank">
                                                <img src="{{ Storage::url($check_pembayaran->foto) }}"
                                                    style="width: 100px; height: 100px; object-fit: cover;">
                                            </a>
                                        </td>
                                    </tr>
                                @endif

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
                                    <tr>
                                        <td>Biaya Pengantaran</td>
                                        <td>:</td>
                                        <td>Rp {{ number_format($item->biaya_pengantaran) }}</td>
                                    </tr>
                                </table>
                            @endif
                            @php
                                $pengantaran = App\Models\Pengantaran::where('id_pesanan', $item->id);
                                $detail_pengantaran = $pengantaran->first();
                            @endphp
                            @if ($pengantaran->count() != 0)
                                <strong>Keterangan Pengantar : </strong>
                                <table class="table table-sm">
                                    <tr>
                                        <td>Sopir</td>
                                        <td>:</td>
                                        <td>{{ $detail_pengantaran->nama_pengantar }}</td>
                                    </tr>
                                    <tr>
                                        <td>Keterangan</td>
                                        <td>:</td>
                                        <td>{{ $detail_pengantaran->keterangan }}</td>
                                    </tr>
                                    @if ($detail_pengantaran->sampai == 1)
                                        <tr>
                                            <td>Foto bukti pesanan sampai</td>
                                            <td>:</td>
                                            <td><a href="{{ Storage::url($detail_pengantaran->foto_bukti) }}"
                                                    target="__blank">
                                                    <img src="{{ Storage::url($detail_pengantaran->foto_bukti) }}"
                                                        style="width: 100px; height: 100px; object-fit: cover;">
                                                </a>
                                            </td>
                                        </tr>
                                    @endif
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </section>
@endsection
