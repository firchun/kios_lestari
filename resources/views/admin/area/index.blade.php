@extends('layouts.backend.admin')

@section('content')
    @include('layouts.backend.alert')
    <div class="dt-action-buttons text-end pt-3 pt-md-0 mb-4">
        <div class=" btn-group " role="group">
            <button class="btn btn-secondary refresh btn-default" type="button">
                <span>
                    <i class="bi bi-arrow-clockwise me-sm-1"> </i>
                    <span class="d-none d-sm-inline-block"></span>
                </span>
            </button>
            <button class="btn btn-secondary create-new btn-primary" type="button" data-bs-toggle="modal"
                data-bs-target="#create">
                <span>
                    <i class="bi bi-plus me-sm-1"> </i>
                    <span class="d-none d-sm-inline-block">Tambah Data</span>
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
                <table id="datatable-area" class="table table-hover table-sm display mb-3">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Biaya Pengantaran</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Biaya Pengantaran</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    @include('admin.area.components.modal')
@endsection
@push('js')
    @push('js')
        <script>
            $(function() {
                $('#datatable-area').DataTable({
                    processing: true,
                    serverSide: false,
                    responsive: false,
                    ajax: '{{ url('area-datatable') }}',
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
                            data: 'action',
                            name: 'action'
                        },

                    ]
                });

                $('.create-new').click(function() {
                    $('#create').modal('show');
                });
                $('.refresh').click(function() {
                    $('#datatable-area').DataTable().ajax.reload();
                });
                window.editCustomer = function(id) {
                    $.ajax({
                        type: 'GET',
                        url: '/area/edit/' + id,
                        success: function(response) {
                            $('#formCustomerId').val(response.id);
                            $('#formCustomerNama').val(response.nama);
                            $('#formCustomerHarga').val(response.harga);
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
                        url: '/area/store',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            alert(response.message);
                            // Refresh DataTable setelah menyimpan perubahan
                            $('#datatable-area').DataTable().ajax.reload();
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
                        url: '/area/store',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            alert(response.message);

                            $('#datatable-area').DataTable().ajax.reload();
                            $('#create').modal('hide');
                        },
                        error: function(xhr) {
                            alert('Terjadi kesalahan: ' + xhr.responseText);
                        }
                    });
                });
                window.deleteCustomers = function(id) {
                    if (confirm('Apakah Anda yakin ingin menghapus area ini?')) {
                        $.ajax({
                            type: 'DELETE',
                            url: '/area/delete/' + id,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                // alert(response.message);
                                $('#datatable-area').DataTable().ajax.reload();
                            },
                            error: function(xhr) {
                                alert('Terjadi kesalahan: ' + xhr.responseText);
                            }
                        });
                    }
                };
            });
        </script>
    @endpush

@endpush
