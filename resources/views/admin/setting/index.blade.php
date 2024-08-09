@extends('layouts.backend.admin')

@section('content')
    <div class="card-box mb-5">
        <div class="card-body">
            <form action="{{ url('/setting/update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <h2>{{ $title }}</h2>
                <hr>
                <div class="mb-3">
                    <label>Jumlah point dalam 1 kali pemesanan</label>
                    <input type="number" name="point" class="form-control" value="{{ $setting->point }}">
                </div>
                <div class="mb-3">
                    <label>Nomor HP/WA Aktif</label>
                    <input name="no_hp" class="form-control" value="{{ $setting->no_hp }}">
                </div>
                <div class="mb-3">
                    <label>Keterangan Kios</label>
                    <textarea name="keterangan_kios" class="form-control">{{ $setting->keterangan_kios }}</textarea>
                </div>
                <div class="mb-3">
                    <label>Alamat Kios</label>
                    <textarea name="alamat" class="form-control">{{ $setting->alamat }}</textarea>
                </div>
                <div class="mb-3">
                    <label>frame google maps</label>
                    <div class="row">
                        <div class="col">

                            <textarea name="google_maps" class="form-control">{{ $setting->google_maps }}</textarea>
                        </div>
                        <div class="col">
                            <div class="p-2 " style="height: 300px; width: 100%; overflow: auto;">
                                {!! $setting->google_maps !!}
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="text-center">
                    <button type="submit" class="btn btn-lg btn-primary">Simpan Pengaturan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
