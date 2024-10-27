<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Stok;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Mail\StockNotification;
use Illuminate\Support\Facades\Mail;

class StokController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Riwayat Stok',
        ];
        return view('admin.stok.index', $data);
    }
    public function getStoksDataTable(Request $request)
    {
        $Stoks = Stok::with(['produk'])->orderByDesc('id');
        if ($request->has('jenis') && $request->input('jenis') != '') {
            $Stoks->where('jenis', $request->input('jenis'));
        }
        if ($request->has('id_produk') && $request->input('id_produk') != '') {
            $Stoks->where('id_produk', $request->input('id_produk'));
        }

        return DataTables::of($Stoks)
            ->addColumn('tanggal', function ($Stok) {
                return $Stok->created_at->format('d F Y');
            })
            ->addColumn('action', function ($Stok) {
                return view('admin.stok.components.actions', compact('Stok'));
            })
            ->addColumn('produk_txt', function ($Stok) {
                $foto = $Stok->produk->foto_produk == null ? asset('img/logo.png') : Storage::url($Stok->produk->foto_produk);
                $nama = '<strong>' . $Stok->produk->nama_produk . '</strong><br><small class="text-mutted"> Satuan : ' . $Stok->produk->satuan_produk . '</small>';
                return '<div class="d-flex"><div class="p-2"><img src="' . $foto . '" style="width:100px; height:auto;"></div><div class="p-2">' . $nama . '</div></div>';
            })
            ->rawColumns(['action', 'produk_txt', 'tanggal'])
            ->make(true);
    }
    public function store(Request $request)
    {

        $StokData = [
            'id_produk' => $request->input('id_produk'),
            'jenis' => $request->input('jenis'),
            'jumlah' => $request->input('jumlah'),
        ];

        $stok_sebelumnya = Stok::getStok($request->input('id_produk'));
        $produk = Produk::find($request->input('id_produk'));

        if (!$produk) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        if ($request->filled('id')) {
            $Stok = Stok::find($request->input('id'));
            if (!$Stok) {
                return response()->json(['message' => 'Stok not found'], 404);
            }

            $Stok->update($StokData);
            $message = 'Stok updated successfully';
        } else {

            $Stok = Stok::create($StokData);
            $message = 'Stok created successfully';
        }

        // Get new stock count
        $stok_baru = Stok::getStok($Stok->id_produk);

        $users = User::where('role', 'User')->get();
        if ($stok_sebelumnya == 0 && $stok_baru > 0) {
            foreach ($users as $user) {
                Mail::to($user->email)->send(new StockNotification('Baru', $produk->nama_produk, $stok_baru));
            }
        } elseif ($stok_sebelumnya > 0 && $stok_baru == 0) {
            foreach ($users as $user) {
                Mail::to($user->email)->send(new StockNotification('Habis', $produk->nama_produk, 0));
            }
        }

        return response()->json(['message' => $message]);
    }
    public function destroy($id)
    {
        $Stoks = Stok::find($id);

        if (!$Stoks) {
            return response()->json(['message' => 'Stok not found'], 404);
        }

        $Stoks->delete();

        return response()->json(['message' => 'Stok deleted successfully']);
    }
    public function edit($id)
    {
        $Stok = Stok::find($id);

        if (!$Stok) {
            return response()->json(['message' => 'Stok not found'], 404);
        }

        return response()->json($Stok);
    }
}
