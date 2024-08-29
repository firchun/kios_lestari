<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->role == 'User') {
            return redirect()->to('/');
        }
        // Get the last 12 months
        $sixMonthsAgo = Carbon::now()->subMonths(6);
        $currentDate = Carbon::now();

        // Buat array untuk semua bulan dalam 6 bulan terakhir
        $allMonths = [];
        for ($i = 0; $i < 6; $i++) {
            $month = $sixMonthsAgo->copy()->addMonths($i)->format('F Y');
            $allMonths[$month] = 0; // Inisialisasi dengan 0
        }

        // Data untuk chart penjualan
        $data_grafik = DB::table('pesanan')
            ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as period'), DB::raw('id_produk'), DB::raw('COUNT(id) as total_sales'))
            ->groupBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'), 'id_produk')
            ->whereBetween('created_at', [$sixMonthsAgo->startOfMonth(), $currentDate->endOfMonth()])
            ->orderBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'))
            ->get();

        // Ambil nama produk dari tabel produk
        $produk = DB::table('produk')->pluck('nama_produk', 'id');

        // Array untuk menyimpan total penjualan berdasarkan produk dan bulan
        $salesData = [];
        foreach ($data_grafik as $item) {
            $month = Carbon::createFromFormat('Y-m', $item->period)->format('F Y');
            $productName = $produk[$item->id_produk] ?? 'Unknown Product';
            $salesData[$productName][$month] = $item->total_sales;
        }

        // Menyiapkan data untuk grafik
        $months = array_keys($allMonths);
        $datasets = [];
        $colors = [
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)',
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)'
        ];

        $borderColors = [
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)',
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)'
        ];
        foreach ($salesData as $productName => $sales) {
            $data = [];
            foreach ($months as $month) {
                $data[] = $sales[$month] ?? 0;
            }
            $datasets[] = [
                'label' => $productName,
                'data' => $data,
                'backgroundColor' =>  $colors[$i % count($colors)],
                'borderColor' =>  $borderColors[$i % count($borderColors)],
                'borderWidth' => 2,
            ];
            $i++;
        }

        // pengantaran
        $pengantaran = DB::table('pesanan')
            ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as period'), DB::raw('COUNT(id) as total_deliveries'))
            ->where('diantar', 1)
            ->whereBetween('created_at', [$sixMonthsAgo->startOfMonth(), $currentDate->endOfMonth()])
            ->groupBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'))
            ->orderBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'))
            ->get();

        $allMonthsPengantaran = [];
        for ($i = 0; $i < 5; $i++) {
            $month = $sixMonthsAgo->copy()->addMonths($i)->format('F Y');
            $allMonthsPengantaran[$month] = 0;
        }

        foreach ($pengantaran as $item) {
            $month = Carbon::createFromFormat('Y-m', $item->period)->format('F Y');
            $allMonthsPengantaran[$month] = $item->total_deliveries;
        }

        $bulanPengantaran = array_keys($allMonthsPengantaran);
        $jumlahPengantaran = array_values($allMonthsPengantaran);
        $data = [
            'title' => 'Dashboard',
            'users' => User::where('role', 'User')->count(),
            'Produk' => Produk::count(),
            'datasets' => $datasets,
            'bulan' => $months,
            'bulanPengantaran' => $bulanPengantaran,
            'jumlahPengantaran' => $jumlahPengantaran,
            'pendapatan' => Pesanan::sum('total_harga')
        ];

        return view('admin.dashboard', $data);
    }
    public function chat()
    {
        $data = [
            'title' => 'Chat',
            'setting' => Setting::getSetting(),
        ];
        return view('pages.chat', $data);
    }
}
