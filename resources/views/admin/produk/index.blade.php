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
                <table id="datatable-produk" class="table table-hover  display mb-3">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Produk</th>
                            <th>Harga Produk</th>
                            <th>Diskon</th>
                            <th>Stok</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Nama Produk</th>
                            <th>Harga Produk</th>
                            <th>Diskon</th>
                            <th>Stok</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    @include('admin.produk.components.modal')
@endsection
@include('admin.produk.script')
