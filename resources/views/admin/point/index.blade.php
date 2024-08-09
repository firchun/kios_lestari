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
                <table id="datatable-users" class="table table-hover display">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Point</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Point</th>
                            <th>Action</th>
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
            $('#datatable-users').DataTable({
                processing: true,
                serverSide: false,
                responsive: false,
                ajax: '{{ url('point-datatable') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },

                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'point',
                        name: 'point'
                    },

                    {
                        data: 'action',
                        name: 'action'
                    }
                ]
            });
            $('.refresh').click(function() {
                $('#datatable-users').DataTable().ajax.reload();
            });
        });
    </script>
@endpush
