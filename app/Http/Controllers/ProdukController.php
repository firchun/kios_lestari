<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ProdukController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Produk',
        ];
        return view('admin.produk.index', $data);
    }
    public function getProdukDataTable()
    {
        $Produks = Produk::orderByDesc('id');

        return DataTables::of($Produks)
            ->addColumn('action', function ($Produk) {
                return view('admin.produk.components.actions', compact('Produk'));
            })
            ->addColumn('nama', function ($Produk) {
                $foto = $Produk->foto_produk == null ? asset('img/logo.png') : Storage::url($Produk->foto_produk);
                $nama = '<strong>' . $Produk->nama_produk . '</strong><br><small class="text-mutted"> Satuan : ' . $Produk->satuan_produk . '</small>';
                $namaProduk = '<div class="d-flex"><div class="p-2"><img src="' . $foto . '" style="width:100px; height:auto;"></div><div class="p-2">' . $nama . '</div></div>';

                return $namaProduk;
            })
            ->addColumn('harga', function ($Produk) {
                return 'Rp ' . number_format($Produk->harga_produk);
            })
            ->addColumn('stok', function ($Produk) {
                $jumlah = Stok::getStok($Produk->id);
                $color = $jumlah > 0 ? 'text-success' : 'text-danger';
                $tambah = ' <button class="btn btn-sm btn-success " onclick="tambahStok(' . $Produk->id . ')">+ Tambah</button>';
                $stok =  '<div class="d-flex align-items-center"><span class="' . $color . ' h2">' . Stok::getStok($Produk->id) . '</span> <small>' . $Produk->satuan_produk . '</small></div>';
                return  $stok . '<div class="btn-group">' . $tambah . '</div>';
            })
            ->rawColumns(['action', 'nama', 'harga', 'stok'])
            ->make(true);
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'satuan_produk' => 'required|string|max:20',
            'keterangan_produk' => 'required|string',
            'harga_produk' => 'required|string',
        ]);

        $ProdukData = [
            'nama_produk' => $request->input('nama_produk'),
            'satuan_produk' => $request->input('satuan_produk'),
            'keterangan_produk' => $request->input('keterangan_produk'),
            'harga_produk' => $request->input('harga_produk'),
        ];

        if ($request->filled('id')) {
            $Produk = Produk::find($request->input('id'));
            if (!$Produk) {
                return response()->json(['message' => 'Produk not found'], 404);
            }

            $Produk->update($ProdukData);
            $message = 'Produk updated successfully';
        } else {
            Produk::create($ProdukData);
            $message = 'Produk created successfully';
        }

        return response()->json(['message' => $message]);
    }
    public function destroy($id)
    {
        $Produks = Produk::find($id);

        if (!$Produks) {
            return response()->json(['message' => 'Produk not found'], 404);
        }

        $Produks->delete();

        return response()->json(['message' => 'Produk deleted successfully']);
    }
    public function edit($id)
    {
        $Produk = Produk::find($id);

        if (!$Produk) {
            return response()->json(['message' => 'Produk not found'], 404);
        }

        return response()->json($Produk);
    }
}
