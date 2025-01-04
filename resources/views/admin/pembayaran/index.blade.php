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
    @foreach ($pembayarans as $pembayaran)
        <div class="modal fade" id="modalTolak-{{ $pembayaran->id }}" tabindex="-1"
            aria-labelledby="modalTolakLabel-{{ $pembayaran->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTolakLabel-{{ $pembayaran->id }}">Keterangan Penolakan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('pembayaran.tolak', $pembayaran->id) }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="keterangan-{{ $pembayaran->id }}" class="form-label">Keterangan
                                    Penolakan</label>
                                <textarea class="form-control" id="keterangan-{{ $pembayaran->id }}" name="keterangan" rows="3" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger">Tolak</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
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
                                if (data == 1) {
                                    return '<span class="badge badge-success">Terverifikasi</span>';
                                } else if (data == 2) {
                                    return '<span class="badge badge-warning">Ditolak</span>';
                                } else if (data == 0) {
                                    return '<span class="badge badge-secondary">Belum</span>';
                                } else {
                                    return '<span class="badge badge-light">Tidak Diketahui</span>'; // Optional: Handle unexpected values
                                }
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
