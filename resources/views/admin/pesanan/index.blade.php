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
            <button class="btn btn-primary create-new" type="button">
                <span>
                    <i class="bi bi-plus me-sm-1"> </i>
                    <span class="d-none d-sm-inline-block">Tambah Pemesanan</span>
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
                <table id="datatable-pesanan" class="table table-hover  display mb-3">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tanggal</th>
                            <th>Invoice</th>
                            <th>Nama Produk</th>
                            <th>Jumlah</th>
                            <th>Tagihan</th>
                            <th>Diantar</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Tanggal</th>
                            <th>Invoice</th>
                            <th>Nama Produk</th>
                            <th>Jumlah</th>
                            <th>Tagihan</th>
                            <th>Diantar</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    @include('admin.pesanan.components.modal')
@endsection
@include('admin.pesanan.script')
