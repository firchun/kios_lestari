<!-- Modal for Create and Edit -->
<div class="modal fade" id="customersModal" tabindex="-1" aria-labelledby="customersModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Update Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    ×
                </button>
            </div>
            <div class="modal-body">
                <!-- Form for Create and Edit -->
                <form id="userForm">
                    <input type="hidden" id="formProdukId" name="id">
                    <div class="mb-3">
                        <label for="formCustomerName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="formCustomerName" name="nama_produk" required>
                    </div>
                    <div class="mb-3">
                        <label for="formCustomerHargProduk" class="form-label">Harga Produk</label>
                        <input type="number" class="form-control" id="formCustomerHargProduk" name="harga_produk"
                            value="0" required>
                    </div>
                    <div class="mb-3">
                        <label for="formCustomerSatuanProduk" class="form-label">Satuan Produk</label>
                        <select name="satuan_produk" id="formCustomerSatuanProduk" class="form-control" required>
                            <option value="kubik">Kubik</option>
                            <option value="ret">Ret</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="formCustomeKeteranganProduk" class="form-label">Keterangan Produk</label>
                        <textarea class="form-control" id="formCustomeKeteranganProduk" name="keterangan_produk" required></textarea>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveCustomerBtn">Save</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="create" tabindex="-1" aria-labelledby="customersModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Tambah Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    ×
                </button>
            </div>
            <div class="modal-body">
                <!-- Form for Create and Edit -->
                <form id="createUserForm">
                    <div class="mb-3">
                        <label for="formCustomerName" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control" id="formCustomerName" name="nama_produk" required>
                    </div>
                    <div class="mb-3">
                        <label for="formCustomerHargProduk" class="form-label">Harga Produk</label>
                        <input type="number" class="form-control" id="formCustomerHargProduk" name="harga_produk"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="formCustomerName" class="form-label">Satuan Produk</label>
                        <select name="satuan_produk" id="formCustomerSatuanProduk" class="form-control">
                            <option value="kubik">Kubik</option>
                            <option value="ret">Ret</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="formCustomeKeteranganProduk" class="form-label">Keterangan Produk</label>
                        <textarea class="form-control" id="formCustomeKeteranganProduk" name="keterangan_produk" required>-</textarea>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="createCustomerBtn">Save</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="tambah-stok" tabindex="-1" aria-labelledby="customersModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Tambah Stok</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    ×
                </button>
            </div>
            <div class="modal-body text-center">
                <form id="formTambahStok">
                    <strong class="text-center h3 mb-3">Produk : <span id="txtNamaProduk"
                            class="text-primary"></span></strong>
                    <input type="hidden" id="stokProdukId" name="id_produk">
                    <input type="hidden" name="jenis" value="masuk">
                    <div class="mb-3">
                        <label>Jumlah Stok</label>
                        <input type="number" class="form-control" name="jumlah" value="1" required>
                    </div>
                    <button type="button" id="btnTambahStok" class="btn btn-primary ">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>
