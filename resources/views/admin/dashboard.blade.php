@extends('layouts.backend.admin')

@section('content')
    <div class="jumbotron text-center bg-transparent py-2">
        <img src="{{ asset('img/logo.png') }}" alt="" style="height: 150px; width:auto;">
        <h3>Wellcome to <span class="text-primary">{{ env('APP_NAME') }}</span></h3>
    </div>
    <hr>
    <div class="title pb-20">
        <h2 class="h3 mb-0">Dashboard Overview</h2>
    </div>
    <div class="row">
        @include('admin.dashboard_component.card1', [
            'count' => $users,
            'title' => 'Users',
            'subtitle' => 'Total users',
            'color' => 'primary',
            'icon' => 'user',
        ])
        @include('admin.dashboard_component.card1', [
            'count' => $Produk,
            'title' => 'Produk',
            'subtitle' => 'Total Produk',
            'color' => 'success',
            'icon' => 'image',
        ])
    </div>
@endsection
