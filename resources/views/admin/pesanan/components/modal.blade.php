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
