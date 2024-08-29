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
                            <select class="form-control" name="sampai" id="selectStatus">
                                <option value="">Pilih Status</option>
                                <option value="1">Sampai</option>
                                <option value="0">Belum</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <button type="button" class="btn btn-primary" id="filter"><i class="bi bi-filter"></i>
                                Filter</button>
                        </div>

                    </div>
                </div>
                <hr>
                <table id="datatable-pengantaran" class="table table-hover table-sm display mb-3">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Invoice</th>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Nama Sopir</th>
                            <th>Keterangan</th>
                            <th>sampai</th>
                            <th>Foto sampai</th>
                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Invoice</th>
                            <th>Produk</th>
                            <th>Nama Sopir</th>
                            <th>Keterangan</th>
                            <th>sampai</th>
                            <th>Foto sampai</th>
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
            table = $('#datatable-pengantaran').DataTable({
                processing: true,
                serverSide: false,
                responsive: false,
                ajax: {
                    url: '{{ url('pengantaran-datatable') }}',
                    data: function(d) {
                        d.selectStatus = $('#selectStatus').val();
                        d.selectProduk = $('#selectProduk').val();
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },

                    {
                        data: 'pesanan.no_invoice',
                        name: 'pesanan.no_invoice'
                    },
                    {
                        data: 'pesanan.produk.nama_produk',
                        name: 'pesanan.produk.nama_produk'
                    },
                    {
                        data: 'pesanan.jumlah',
                        name: 'pesanan.jumlah'
                    },
                    {
                        data: 'nama_pengantar',
                        name: 'nama_pengantar'
                    },

                    {
                        data: 'keterangan',
                        name: 'keterangan'
                    },
                    {
                        data: 'sampai',
                        name: 'sampai',
                        render: function(data, type, row) {
                            return data == 1 ? '<span class="badge badge-success">Sampai</span>' :
                                '<span class="badge badge-danger">Belum</span>';
                        }

                    },
                    {
                        data: 'bukti',
                        name: 'bukti'
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
                table.ajax.reload();
            });

            $('#filter').click(function() {
                table.ajax.url('{{ url('pengantaran-datatable') }}?' + $.param({
                    sampai: $('#selectStatus').val(),
                    id_produk: $('#selectProduk').val(),
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
