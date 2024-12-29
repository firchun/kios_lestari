@php
    $idPesanan = $item->id;
@endphp
@if (App\Models\Rating::where('id_pesanan', $item->id)->count() == 0)
    <div class="modal fade" id="ulasan-{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
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
                            <input type="number" name="rating" class="form-control" min="0" max="5"
                                required>
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
                        <input type="hidden" name="id_pesanan" value="{{ $idPesanan }}">
                        <div class="mb-3">
                            <label>Jumlah Pembayaran (Rp)</label>
                            <input type="number" name="jumlah" class="form-control" value="{{ $item->total_harga }}"
                                required>
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

@php

    $statusPesanan = $item->status;
@endphp
<div class="modal fade" id="detailPesanan-{{ $item->id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                Detail Pesanan {{ $item->no_invoice }}
            </div>
            <div class="modal-body">
                <div class="alert alert-primary  show" role="alert">
                    Status : <strong> {{ $statusPesanan }}</strong>
                </div>
                @if (App\Models\Rating::where('id_pesanan', $item->id)->count() != 0)
                    <div class="alert alert-warning  show" role="alert">
                        Terimakasih telah memberikan rating dan ulasan anda...<br>
                        <div class="d-flex  align-items-center my-2">
                            @php
                                $ulasan = App\Models\Rating::where('id_pesanan', $item->id)->first()->ulasan;
                                $rating = App\Models\Rating::where('id_pesanan', $item->id)->first()->rating;
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
                                <td><a href="{{ Storage::url($detail_pengantaran->foto_bukti) }}" target="__blank">
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
