@push('js')
    <script>
        $(function() {
            $('#datatable-produk').DataTable({
                processing: true,
                serverSide: false,
                responsive: false,
                scrollX: false,
                ajax: '{{ url('produk-datatable') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },

                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'harga',
                        name: 'harga'
                    },
                    {
                        data: 'diskon',
                        name: 'diskon'
                    },
                    {
                        data: 'stok',
                        name: 'stok'
                    },

                    {
                        data: 'action',
                        name: 'action'
                    }
                ]
            });
            $('.create-new').click(function() {
                $('#create').modal('show');
            });
            $('.refresh').click(function() {
                $('#datatable-produk').DataTable().ajax.reload();
            });
            window.editCustomer = function(id) {
                $.ajax({
                    type: 'GET',
                    url: '/produk/edit/' + id,
                    success: function(response) {
                        $('#customersModalLabel').text('Edit Customer');
                        $('#formProdukId').val(response.id);
                        $('#formCustomerName').val(response.nama_produk);
                        $('#formCustomerHargProduk').val(response.harga_produk);
                        $('#formCustomeKeteranganProduk').val(response.keterangan_produk);

                        // Clear options first (optional, if you are dynamically populating options)
                        $('#formCustomerSatuanProduk').empty();

                        // Populate options for Satuan Produk
                        var options = '';
                        options += '<option value="kubik" ' + (response.satuan_produk === 'kubik' ?
                            'selected' : '') + '>Kubik</option>';
                        options += '<option value="ret" ' + (response.satuan_produk === 'ret' ?
                            'selected' : '') + '>Ret</option>';
                        $('#formCustomerSatuanProduk').html(options);

                        $('#customersModal').modal('show');
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            };
            $('#saveCustomerBtn').click(function() {
                var formData = $('#userForm').serialize();

                $.ajax({
                    type: 'POST',
                    url: '/produk/store',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert(response.message);
                        // Refresh DataTable setelah menyimpan perubahan
                        $('#datatable-produk').DataTable().ajax.reload();
                        $('#customersModal').modal('hide');
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            });
            $('#createCustomerBtn').click(function() {
                var formData = $('#createUserForm').serialize();

                $.ajax({
                    type: 'POST',
                    url: '/produk/store',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert(response.message);
                        $('#customersModalLabel').text('Edit Customer');
                        $('#formCustomerName').val('');
                        $('#datatable-produk').DataTable().ajax.reload();
                        $('#create').modal('hide');
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            });

            window.deleteCustomers = function(id) {
                if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                    $.ajax({
                        type: 'DELETE',
                        url: '/produk/delete/' + id,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            // alert(response.message);
                            $('#datatable-produk').DataTable().ajax.reload();
                        },
                        error: function(xhr) {
                            alert('Terjadi kesalahan: ' + xhr.responseText);
                        }
                    });
                }
            };
            window.tambahStok = function(id) {
                $('#tambah-stok').modal('show');
                $.ajax({
                    type: 'GET',
                    url: '/produk/edit/' + id,
                    success: function(response) {
                        $('#stokProdukId').val(response.id);
                        $('#txtNamaProduk').text(response.nama_produk);
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            };
            $('#btnTambahStok').click(function() {
                var formData = $('#formTambahStok').serialize();

                $.ajax({
                    type: 'POST',
                    url: '/stok/store',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert(response.message);
                        $('#datatable-produk').DataTable().ajax.reload();
                        $('#tambah-stok').modal('hide');
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            });
        });
    </script>
@endpush
