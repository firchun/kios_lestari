<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
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

            ->rawColumns(['action'])
            ->make(true);
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'satuan_produk' => 'required|string|max:20',
            'keterangan_produk' => 'required|string',
        ]);

        $ProdukData = [
            'nama_produk' => $request->input('nama_produk'),
            'satuan_produk' => $request->input('satuan_produk'),
            'keterangan_produk' => $request->input('keterangan_produk'),
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
