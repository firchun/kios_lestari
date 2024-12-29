@push('js')
    <script>
        $(function() {
            $('#datatable-pesanan').DataTable({
                processing: true,
                serverSide: false,
                responsive: false,
                scrollX: false,
                ajax: '{{ url('pesanan-datatable') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },

                    {
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'invoice',
                        name: 'invoice'
                    },
                    {
                        data: 'produk_txt',
                        name: 'produk_txt'
                    },
                    {
                        data: 'jumlah',
                        name: 'jumlah'
                    },
                    {
                        data: 'tagihan',
                        name: 'tagihan'
                    },
                    {
                        data: 'pengantaran',
                        name: 'pengantaran'
                    },
                    {
                        data: 'status',
                        name: 'status'
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
                $('#datatable-pesanan').DataTable().ajax.reload();
            });
            window.updatePesanan = function(id) {
                $('#updatepesanan').modal('show');
                $('#loadingIndicatorUpdatePesanan').show();
                $.ajax({
                    type: 'GET',
                    url: '/pesanan/edit/' + id,
                    success: function(response) {
                        $('#idPesanan').val(response.id);
                        $('#selectStatus').val(response.status);
                        $('#formUpdatePesanan').show();
                        $('#formUpdatePembayaran').hide();
                        $('#loadingIndicatorUpdatePesanan').hide();
                        if (response.jenis == 'pre-order') {
                            $('#estimasiPengiriman').show();
                        } else {
                            $('#estimasiPengiriman').hide();

                        }
                    },
                    error: function(xhr) {
                        $('#loadingIndicatorUpdatePesanan').hide();
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            }
            window.updatePengantaran = function(id) {
                $('#pengantaran').modal('show');
                $.ajax({
                    type: 'GET',
                    url: '/pengantaran/pesanan/' + id,
                    success: function(response) {
                        if ($.isEmptyObject(response)) {
                            // Jika respons kosong, tampilkan formPengantaran dan sembunyikan updatePengantaranSelesai

                            $('#formPengantaran').show();
                            $('#updatePengantaranSelesai').hide();
                        } else {
                            if (Number(response.sampai) === 0) {
                                // Jika sampai === 0, isi nilai id ke idPengantaran, sembunyikan formPengantaran, dan tampilkan updatePengantaranSelesai
                                $('#idPengantaran').val(response.id);
                                $('#formPengantaran').hide();

                                $('#updatePengantaranSelesai').show();
                            } else {
                                // Jika sampai !== 0, sembunyikan kedua elemen
                                $('#formPengantaran').hide();
                                $('#updatePengantaranSelesai').hide();
                            }
                        }
                    },
                    error: function(xhr) {
                        $('#loadingIndicator').hide();
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });

                $.ajax({
                    type: 'GET',
                    url: '/pesanan/edit/' + id,
                    success: function(response) {
                        $('#idPesanan2').val(response.id);
                        $('#tablePengantaran').empty();
                        var html = `
                            <strong>Detail Pengantaran :</strong>
                            <table class="table table-sm">
                                <tr>
                                    <td>Penerima</td>
                                    <td>:</td>
                                    <td>${response.nama_penerima}</td>
                                </tr>
                                <tr>
                                    <td>No. HP/WA</td>
                                    <td>:</td>
                                    <td>${response.nomor_penerima}</td>
                                </tr>
                                <tr>
                                    <td>Alamat Pengantaran</td>
                                    <td>:</td>
                                    <td>${response.alamat_pengantaran}</td>
                                </tr>
                            </table>
                        `;
                        $('#tablePengantaran').html(html);
                        $('#tablePengantaran').show();
                    },
                    error: function(xhr) {
                        $('#loadingIndicator').hide();
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });

            };
            window.detailPesanan = function(id) {
                $('#detail').modal('show');
                $('#loadingIndicator').show();

                $.ajax({
                    type: 'GET',
                    url: '/pesanan/edit/' + id,
                    success: function(response) {
                        // Bersihkan konten modal-body
                        $('#tableDetail').empty();

                        // Bangun tabel dengan data yang diterima
                        var table = $('<table class="table table-sm"></table>');
                        table.append('<tr><td>Produk</td><td>:</td><td>' + response.produk
                            .nama_produk + '</td></tr>');


                        table.append('<tr><td>Jenis</td><td>:</td><td>' + response.jenis + '<br>' +
                            (response.jenis == 'pre-order' ?
                                '<small class="text-danger">*pesanan akan diprioritaskan jika stok tersedia</small>' :
                                '') +
                            '</td></tr>');
                        if (response.jenis == 'pre-order') {
                            table.append('<tr><td>Estimasi Pengiriman</td><td>:</td><td>' + response
                                .estimasi_pengiriman + '</td></tr>');
                        }

                        table.append('<tr><td>Harga</td><td>:</td><td class="text-danger">Rp ' +
                            numberFormat(response.produk.harga_produk) + '</td></tr>');
                        table.append('<tr><td>Jumlah dipesan</td><td>:</td><td>' + response.jumlah +
                            ' ' + response.produk.satuan_produk + '</td></tr>');
                        table.append(
                            '<tr><td>Total Tagihan</td><td>:</td><td class="text-danger">Rp ' +
                            numberFormat(response.total_harga) + '</td></tr>');
                        var diantar = response.diantar == 1 ?
                            '<strong class="text-primary">Diantar</strong>' :
                            '<strong class="text-danger">Tidak</strong>';
                        table.append('<tr><td>Pengantaran</td><td>:</td><td>' + diantar +
                            '</td></tr>');

                        // Tambahkan tabel ke dalam modal-body
                        $('#tableDetail').append(table);

                        // Tampilkan detail pengantaran jika diantar == 1

                        // Sembunyikan indikator loading setelah semua data dimuat
                        $('#loadingIndicator').hide();
                    },
                    error: function(xhr) {
                        $('#loadingIndicator').hide();
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            };


            function numberFormat(number) {
                return new Intl.NumberFormat('id-ID').format(number);
            }
            $('#createPengantaranBtn').click(function() {
                var formData = $('#createPengantaran').serialize();

                $.ajax({
                    type: 'POST',
                    url: '/pengantaran/store',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert(response.message);
                        $('#datatable-pesanan').DataTable().ajax.reload();
                        $('#pengantaran').modal('hide');
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            });
            $('#pengantaranSelesaiBtn').click(function() {
                var formData = new FormData($('#formUpdatePengantaran')[0]);

                $.ajax({
                    type: 'POST',
                    url: '/pengantaran/store',
                    data: formData,
                    processData: false, // Prevent jQuery from automatically transforming the data into a query string
                    contentType: false, // Prevent jQuery from setting Content-Type header
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert(response.message);
                        $('#datatable-pesanan').DataTable().ajax.reload();
                        $('#pengantaran').modal('hide');
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            });

        });
    </script>
@endpush
