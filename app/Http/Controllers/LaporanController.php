<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function pengantaran()
    {
        $data = [
            'title' => 'Laporan Pengantaran'

        ];
        return view('admin.laporan.pengantaran', $data);
    }
    public function keuangan()
    {
        $data = [
            'title' => 'Laporan Keuangan'

        ];
        return view('admin.laporan.keuangan', $data);
    }
    public function suplai()
    {
        $data = [
            'title' => 'Laporan Suplai Stok'

        ];
        return view('admin.laporan.suplai', $data);
    }
    public function penjualan()
    {
        $data = [
            'title' => 'Laporan Penjualan'

        ];
        return view('admin.laporan.penjualan', $data);
    }
}
