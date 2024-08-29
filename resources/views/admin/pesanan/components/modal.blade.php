<!-- Modal for Create and Edit -->
<div class="modal fade" id="pengantaran" tabindex="-1" aria-labelledby="customersModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Pengantaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    ×
                </button>
            </div>
            <div class="modal-body">
                <div class="p-2 border mb-4 shadow-sm" id="tablePengantaran" style="border-radius: 10px;">

                </div>

                <!-- Form for Create and Edit -->
                <div id="formPengantaran">
                    <form id="createPengantaran">
                        <input type="hidden" id="idPesanan" name="id_pesanan">
                        <div class="mb-3">
                            <label>Nama Pengantar / Sopir</label>
                            <input type="text" name="nama_pengantar" class="form-control"
                                placeholder="Nama Pengantar" required>
                        </div>
                        <div class="mb-3">
                            <label>Keterangan pengantaran</label>
                            <textarea type="text" name="keterangan" class="form-control">-</textarea>
                        </div>
                        <button type="button" class="btn btn-primary" id="createPengantaranBtn">Update
                            Pengantaran</button>
                    </form>
                </div>
                <div id="updatePengantaranSelesai">
                    <form id="formUpdatePengantaran">
                        <input type="hidden" name="id_pengantaran" id="idPengantaran">
                        <div class="mb-3">
                            <label>Bukti Pengantaran</label>
                            <input type="file" name="foto_bukti" class="form-control">
                        </div>
                        <input type="hidden" name="sampai" value="1">

                        <button type="button" class="btn btn-primary" id="pengantaranSelesaiBtn">Pengantaran
                            Selesai</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Modal for Create and Edit -->
<div class="modal fade" id="detail" tabindex="-1" aria-labelledby="customersModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Detail Pesanan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    ×
                </button>
            </div>
            <div class="modal-body">
                <div id="loadingIndicator" style="display: none;">
                    <div class="text-center">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <div class="" id="tableDetail"></div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>
{{-- create --}}
<div class="modal fade" id="create" tabindex="-1" aria-labelledby="customersModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Tambah Pesanan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    ×
                </button>
            </div>
            <form action="{{ route('pesanan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    {{-- <input type="hidden" name="id_user" value="{{ Auth::id() }}"> --}}
                    {{-- <input type="hidden" name="id_produk" value="{{ $produk->id }}"> --}}

                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label> Pilih Pelanggan : &nbsp; &nbsp;</label>
                                <select class="form-control" name="id_user">
                                    @foreach (App\Models\User::where('role', 'User')->get() as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3 ">
                                <label> Pilih Produk : &nbsp; &nbsp;</label>
                                <select class="form-control" name="id_produk">
                                    @foreach (App\Models\Produk::all() as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama_produk }} -
                                            {{ $item->harga_produk }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

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
                                        <option>{{ $item->nama }} - Rp {{ number_format($item->harga) }}</option>
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

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
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
