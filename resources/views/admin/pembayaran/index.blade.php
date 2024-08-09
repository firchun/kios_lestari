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
                <table id="datatable-pembayaran" class="table table-hover table-sm display mb-3">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Foto</th>
                            <th>Invoice</th>
                            <th>Produk</th>
                            <th>Pelanggan</th>
                            <th>Jumlah</th>
                            <th>verifikasi</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Foto</th>
                            <th>Invoice</th>
                            <th>Produk</th>
                            <th>Pelanggan</th>
                            <th>Jumlah</th>
                            <th>verifikasi</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('js')
    @push('js')
        <script>
            $(function() {
                $('#datatable-pembayaran').DataTable({
                    processing: true,
                    serverSide: false,
                    responsive: false,
                    ajax: '{{ url('pembayaran-datatable') }}',
                    columns: [{
                            data: 'id',
                            name: 'id'
                        },

                        {
                            data: 'foto',
                            name: 'foto'
                        },
                        {
                            data: 'pesanan.no_invoice',
                            name: 'pesanan.no_invoice'
                        },

                        {
                            data: 'produk',
                            name: 'produk'
                        },
                        {
                            data: 'pelanggan',
                            name: 'pelanggan'
                        },
                        {
                            data: 'jumlah',
                            name: 'jumlah'
                        },
                        {
                            data: 'terverifikasi',
                            name: 'terverifikasi',
                            render: function(data, type, row) {
                                return data == 1 ?
                                    '<span class="badge badge-success">Terverifikasi</span>' :
                                    '<span class="badge badge-danger">Belum</span>';
                            }

                        },
                        {
                            data: 'action',
                            name: 'action'
                        },

                    ]
                });

                $('.refresh').click(function() {
                    $('#datatable-pembayaran').DataTable().ajax.reload();
                });

            });
        </script>
    @endpush

@endpush
