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
    <div class="my-3">
        <div class="row justify-content-center">
            <div class="col-12 mb-3">
                <canvas id="chartPenjualan" class="card-box" style="width: 100%; height:400px;"></canvas>
            </div>
            <div class="col-12 mb-3">
                <canvas id="chartPengantaran" class="card-box" style="width: 100%;height:400px;"></canvas>
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
