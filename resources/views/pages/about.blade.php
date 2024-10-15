@extends('layouts.frontend.app')

@section('content')
    <div class="breacrumb-section mb-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a>
                        <span>{{ $title ?? 'Semua produk' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mb-5">
        <div class="row">
            <div class="col-lg-6">
                <strong>Keterangan Kios :</strong><br>
                <p>{{ $setting->keterangan_kios }}</p>
                <hr>
                <strong>Kontak :</strong><br>
                <p>{{ $setting->no_hp }}</p>
                <hr>
                <strong>Alamat :</strong><br>
                <p>{{ $setting->alamat }}</p>
                <hr>
            </div>
            <div class="col-lg-6">
                {!! $setting->google_maps !!}
            </div>
        </div>
    </div>
    @include('pages._instagram')
@endsection
