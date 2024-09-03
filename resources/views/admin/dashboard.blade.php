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
    @php
        // Controller method or anywhere in your code
        $stokKosong = App\Models\Produk::select('produk.id', 'produk.nama_produk', 'produk.satuan_produk')
            ->selectRaw(
                'COALESCE(SUM(CASE WHEN stok.jenis = "masuk" THEN stok.jumlah ELSE 0 END), 0) AS total_pemasukan',
            )
            ->selectRaw(
                'COALESCE(SUM(CASE WHEN stok.jenis = "penjualan" THEN stok.jumlah ELSE 0 END), 0) AS total_penjualan',
            )
            ->selectRaw(
                'COALESCE(SUM(CASE WHEN stok.jenis = "masuk" THEN stok.jumlah ELSE 0 END), 0) - COALESCE(SUM(CASE WHEN stok.jenis = "penjualan" THEN stok.jumlah ELSE 0 END), 0) AS stok_tersisa',
            )
            ->leftJoin('stok as stok', 'produk.id', '=', 'stok.id_produk') // Alias 'stok' digunakan di sini
            ->groupBy('produk.id', 'produk.nama_produk', 'produk.satuan_produk')
            ->havingRaw('stok_tersisa <= 0')
            ->get();

    @endphp
    @if ($stokKosong->count() != 0)
        <div class="my-3">
            <div class="alert alert-danger  show" role="alert">
                {{ $stokKosong->count() }} Produk telah kosong, Harap siapkan stok..
            </div>
        </div>
    @endif
    @if (App\Models\Pesanan::with(['produk', 'user'])->where('jenis', 'pre-order')->where('status', 'pesanan diproses')->count() != 0)
        <div class="my-3">
            <div class="alert alert-warning  show" role="alert">
                Mohon untuk prioritas stok pada pesanan pre-order jika tersedia..
            </div>
        </div>
        <div class="my-4">
            <h2 class="h3 mb-0">Kebutuhan Stok pre-order</h2>
            @php
                $produkStok = App\Models\Pesanan::select('id_produk')
                    ->selectRaw('SUM(jumlah) as total_jumlah')
                    ->where('jenis', 'pre-order')
                    ->where('status', 'pesanan diproses')
                    ->groupBy('id_produk')
                    ->with('produk') // Mengambil informasi produk terkait
                    ->get();
            @endphp
            <div class="row">
                @foreach ($produkStok as $item)
                    <div class="col-md-3">
                        <div class="p-2 border bg-danger text-white" style="border-radius: 10px;">

                            {{ $item->produk->nama_produk }} : <b>{{ $item->total_jumlah }}
                                {{ $item->produk->satuan_produk }}</b>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif


    @if ($stokKosong->count() != 0)
        <div class="my-4">
            <h2 class="h3 mb-0">Stok Kosong</h2>
            <div class="row">
                @foreach ($stokKosong as $item)
                    <div class="col-md-3 mb-3">
                        <div class="p-3 border bg-danger text-white" style="border-radius: 10px;">
                            <b>{{ $item->nama_produk }}</b>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <div class="my-3">
        <div class="row">
            <div class="col-md-8">
                <div class="row justify-content-center">
                    <div class="col-12 mb-3">
                        <canvas id="chartPenjualan" class="card-box" style="width: 100%; height:400px;"></canvas>
                    </div>
                    <div class="col-12 mb-3">
                        <canvas id="chartPengantaran" class="card-box" style="width: 100%;height:400px;"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <strong>Daftar Pre-order
                            ({{ App\Models\Pesanan::with(['produk', 'user'])->where('jenis', 'pre-order')->where('status', 'pesanan diproses')->count() }})</strong>
                    </div>
                    <div class="card-body">

                        @forelse (App\Models\Pesanan::with(['produk', 'user'])->where('jenis', 'pre-order')->where('status', 'pesanan diproses')->limit(5)->get() as $item)
                            <div class="list-group mb-3">
                                <div class="list-group-item">
                                    <h5 class="mb-1">Pesanan #{{ $loop->iteration }}</h5>
                                    <p class="mb-1"><strong>No Invoice:</strong> {{ $item->no_invoice }}</p>
                                    <p class="mb-1"><strong>Nama Pengguna:</strong> {{ $item->user->name }}</p>
                                    <p class="mb-1"><strong>Produk:</strong> {{ $item->produk->nama_produk }}</p>
                                    <p class="mb-1"><strong>Jumlah:</strong> {{ $item->jumlah }}
                                        {{ $item->produk->satuan_produk }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-info" role="alert">
                                Belum ada pre-order
                            </div>
                        @endforelse

                    </div>
                    <div class="card-footer">
                        <a href="{{ route('pemesanan') }}" class="btn btn-primary">Lihat Semua</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <hr>
    <div class="row justify-content-center">
        @include('admin.dashboard_component.card1', [
            'count' => $users,
            'title' => 'Pelanggan',
            'subtitle' => 'Total Pelanggan',
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
        @include('admin.dashboard_component.card1', [
            'count' => $pendapatan,
            'title' => 'Pendpatan',
            'subtitle' => 'Total Pendapatan',
            'color' => 'success',
            'icon' => 'money',
        ])
    </div>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Chart Penjualan
        const ctxPenjualan = document.getElementById('chartPenjualan').getContext('2d');
        const labels = @json($bulan);
        const datasets = @json($datasets);

        new Chart(ctxPenjualan, {
            type: 'line',
            data: {
                labels: labels,
                datasets: datasets
            },
            options: {
                scales: {
                    x: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Bulan'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Total Penjualan'
                        }
                    }
                },
                elements: {
                    line: {
                        tension: 0.1 // Interpolasi line
                    },
                    point: {
                        radius: 5, // Ukuran titik data
                        hoverRadius: 7 // Ukuran titik data saat hover
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return `${tooltipItem.dataset.label}: ${tooltipItem.raw}`;
                            }
                        }
                    }
                }
            }
        });

        // Chart Pengantaran
        const ctxPengantaran = document.getElementById('chartPengantaran').getContext('2d');
        const labelsPengantaran = @json($bulanPengantaran);
        const dataPengantaran = @json($jumlahPengantaran);

        new Chart(ctxPengantaran, {
            type: 'bar',
            data: {
                labels: labelsPengantaran,
                datasets: [{
                    label: 'Pengantaran per Bulan',
                    data: dataPengantaran,
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    x: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Bulan'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah Pengantaran'
                        }
                    }
                }
            }
        });
    </script>
@endpush
