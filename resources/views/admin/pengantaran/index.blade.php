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
                <table id="datatable-pengantaran" class="table table-hover table-sm display mb-3">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Sopir</th>
                            <th>Keterangan</th>
                            <th>sampai</th>
                            <th>Foto sampai</th>
                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                            <th>ID</th>
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
    @include('admin.return.components.modal')
@endsection
@push('js')
    @push('js')
        <script>
            $(function() {
                $('#datatable-pengantaran').DataTable({
                    processing: true,
                    serverSide: false,
                    responsive: false,
                    ajax: '{{ url('pengantaran-datatable') }}',
                    columns: [{
                            data: 'id',
                            name: 'id'
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

                    ]
                });

                $('.refresh').click(function() {
                    $('#datatable-pengantaran').DataTable().ajax.reload();
                });

            });
        </script>
    @endpush

@endpush
