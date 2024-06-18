<?php

namespace App\Http\Controllers;

use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ReturnController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Data Pengembalian Barang',
        ];
        return view('admin.return.index', $data);
    }
    public function getReturnDataTable()
    {
        $Stoks = Stok::with(['produk'])->where('jenis', 'rusak')->orderByDesc('id');

        return DataTables::of($Stoks)
            ->addColumn('tanggal', function ($Stok) {
                return $Stok->created_at->format('d F Y');
            })
            ->addColumn('action', function ($Stok) {
                return view('admin.return.components.actions', compact('Stok'));
            })
            ->addColumn('produk', function ($Stok) {
                $foto = $Stok->produk->foto_produk == null ? asset('img/logo.png') : Storage::url($Stok->produk->foto_produk);
                $nama = '<strong>' . $Stok->produk->nama_produk . '</strong><br><small class="text-mutted"> Satuan : ' . $Stok->produk->satuan_produk . '</small>';
                return '<div class="d-flex"><div class="p-2"><img src="' . $foto . '" style="width:100px; height:auto;"></div><div class="p-2">' . $nama . '</div></div>';
            })
            ->rawColumns(['action', 'produk', 'tanggal'])
            ->make(true);
    }
}
