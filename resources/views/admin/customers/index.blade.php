@extends('layouts.backend.admin')

@section('content')
    @include('layouts.backend.alert')

    <div class=" btn-group mb-3" role="group">
        <button class="btn btn-secondary refresh " type="button">
            <span>
                <i class="bx bx-sync "> </i>
                <span class="d-none d-sm-inline-block"></span>
            </span>
        </button>
        <button class="btn  create-new btn-primary" type="button" data-toggle="modal" data-target="#create">
            <span>
                <i class="bx bx-plus"></i>
                <span class="d-none d-sm-inline-block">Tambah Data</span>
            </span>
        </button>
    </div>
    <div class="widget-content widget-content-area br-6">
        <h3 class="">{{ $title ?? 'Title' }}</h3>
        <div class="table-responsive mb-4 mt-4">
            <table id="datatable-customers" class="table table-hover table-bordered dataTable" role="grid">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    @include('admin.customers.components.modal')
@endsection
@include('admin.customers.script')
