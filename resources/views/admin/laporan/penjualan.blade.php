@extends('layouts.backend.admin')

@section('content')
    @include('layouts.backend.alert')
    <div class="dt-action-buttons text-end pt-3 pt-md-0 mb-4">
        <div class=" btn-group " role="group">
            <button class="btn btn-secondary refresh btn-default" type="button">
                <span>
                    <i class="bi bi-arrow-clockwise me-sm-1"> </i>
                    <span class="d-none d-sm-inline-block">Refresh Data</span>
                </span>
            </button>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card-box mb-30">
                <div class="card-body">
                    <h2>{{ $title }}</h2>
                </div>
                <hr>
                <div class="m-2">
                    <label>Filter Laporan :</label>
                    <div class="row justify-content-center">
                        <div class="col-md-3">
                            <select class="form-control" name="id_produk" id="selectProduk">
                                <option value="">Pilih Produk</option>
                                @foreach (App\Models\Produk::all() as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_produk }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control" name="jenis" id="selectJenis">
                                <option value="">Pilih Jenis</option>
                                <option value="order">Order</option>
                                <option value="pre-order">Pre-Order</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control" name="diantar" id="selectDiantar">
                                <option value="">Pilih Pengantaran</option>
                                <option value="1">Diantar</option>
                                <option value="0">Tidak</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <button type="button" class="btn btn-primary" id="filter"><i class="bi bi-filter"></i>
                                Filter</button>
                        </div>

                    </div>
                </div>
                <hr>
                <table id="datatable-penjualan" class="table table-hover table-sm display mb-3">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tanggal</th>
                            <th>Invoice</th>
                            <th>Jenis</th>
                            <th>Nama Produk</th>
                            <th>Jumlah</th>
                            <th>Tagihan</th>
                            <th>Diantar</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Tanggal</th>
                            <th>Invoice</th>
                            <th>Jenis</th>
                            <th>Nama Produk</th>
                            <th>Jumlah</th>
                            <th>Tagihan</th>
                            <th>Diantar</th>
                            <th>Status</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(function() {
            table = $('#datatable-penjualan').DataTable({
                processing: true,
                serverSide: false,
                responsive: false,
                scrollX: false,
                ajax: {
                    url: '{{ url('pesanan-datatable') }}',
                    data: function(d) {
                        d.selectProduk = $('#selectProduk').val();
                        d.selectJenis = $('#selectJenis').val();
                        d.selectDiantar = $('#selectDiantar').val();
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },

                    {
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'no_invoice',
                        name: 'no_invoice'
                    },
                    {
                        data: 'jenis',
                        name: 'jenis'
                    },
                    {
                        data: 'produk.nama_produk',
                        name: 'produk.nama_produk'
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


                ],
                dom: 'Blfrtip',
                buttons: [{
                        extend: 'pdf',
                        text: '<i class="bi bi-file-pdf"></i> PDF',
                        className: 'btn-danger mx-3 mb-4',
                        orientation: 'landscape',
                        title: '{{ $title }}',
                        pageSize: 'A4',
                        exportOptions: {
                            columns: ':visible'
                        },
                        customize: function(doc) {
                            doc.defaultStyle.fontSize = 8;
                            doc.styles.tableHeader.fontSize = 8;
                            doc.styles.tableHeader.fillColor = '#2a6908';


                        },
                        header: true
                    },
                    {
                        extend: 'excelHtml5',
                        text: '<i class="bi bi-file-earmark-excel"></i> Excel',
                        className: 'btn-success mb-4',
                        exportOptions: {
                            columns: ':visible'
                        }
                    }
                ]
            });
            $('.refresh').click(function() {
                $('#datatable-penjualan').DataTable().ajax.reload();
            });
            $('.refresh').click(function() {
                table.ajax.reload();
            });

            $('#filter').click(function() {
                table.ajax.url('{{ url('pesanan-datatable') }}?' + $.param({
                    jenis: $('#selectJenis').val(),
                    id_produk: $('#selectProduk').val(),
                    diantar: $('#selectDiantar').val(),
                })).load();
            });

        });
    </script>
    <!-- JS DataTables Buttons -->
    <script src="https://cdn.datatables.net/buttons/2.1.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.1/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
@endpush
