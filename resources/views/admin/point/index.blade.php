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
    <div class="my-4">
        <div class="row">
            <div class="col-md-3">
                <div class="card card-box">
                    <div class="card-header">
                        Ketentuan Point
                    </div>
                    <div class="card-body font-weight-bold text-danger">
                        1 point = Rp {{ number_format(App\Models\Setting::first()->saldo_point) }}
                    </div>
                    <div class="card-footer">
                        <small class="font-weight-italic">Ketentuan dapat dirubah pada setting</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-box">
                    <div class="card-header">
                        Ketentuan Transaksi
                    </div>
                    <div class="card-body font-weight-bold text-danger">
                        1x Transaksi = {{ number_format(App\Models\Setting::first()->point) }} Point
                    </div>
                    <div class="card-footer">
                        <small class="font-weight-italic">Ketentuan dapat dirubah pada setting</small>
                    </div>
                </div>
            </div>
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
                            <th>Saldo</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Point</th>
                            <th>Saldo</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    {{-- modal --}}
    <div class="modal fade" id="change" tabindex="-1" aria-labelledby="customersModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel">Gunakan point : <span id="namaUser"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        ×
                    </button>
                </div>
                <form id="formChangePoint">
                    <div class="modal-body">
                        <div class="d-flex justify-content-end">
                            <div class="">
                                <h3 class="text-danger" id="jumlah-rupiah">Rp </h3>
                            </div>
                        </div>
                        <input type="hidden" name="id_user" id="idChange">
                        <div class="mb-3">
                            <label>Jumlah Point</label>
                            <input type="number" class="form-control" name="jumlah" id="jumlahPoint" value="1"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="btnSaveChange">Submit</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            function updateAmount() {
                var jumlah = $('#jumlahPoint').val();

                var amount = jumlah * {{ App\Models\Setting::first()->saldo_point }};

                var formattedAmount = 'Rp ' + amount.toLocaleString('id-ID');

                $('#jumlah-rupiah').text(formattedAmount);
            }

            updateAmount();

            // Attach an event listener to the input to call the updateAmount function on change
            $('#jumlahPoint').on('input', function() {
                updateAmount();
            });
        });
    </script>
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
                        data: 'saldo',
                        name: 'saldo'
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
        window.change = function(id) {
            $('#change').modal('show');
            $.ajax({
                type: 'GET',
                url: '/users/edit/' + id,
                success: function(response) {
                    $('#namaUser').text(response.name);
                    $('#idChange').val(response.id);

                },
                error: function(xhr) {
                    alert('Terjadi kesalahan: ' + xhr.responseText);
                }
            });

        };
        $('#btnSaveChange').click(function() {
            var formData = $('#formChangePoint').serialize();

            $.ajax({
                type: 'POST',
                url: '/point/store',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    alert(response.message);
                    $('#datatable-users').DataTable().ajax.reload();
                    $('#change').modal('hide');
                },
                error: function(xhr) {
                    alert('Terjadi kesalahan: ' + xhr.responseText);
                }
            });
        });
    </script>
@endpush
