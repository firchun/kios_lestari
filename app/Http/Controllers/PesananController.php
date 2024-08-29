<?php

namespace App\Http\Controllers;

use App\Models\AreaPengantaran;
use App\Models\Keranjang;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class PesananController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Data Pemesanan',
        ];
        return view('admin.pesanan.index', $data);
    }
    public function getPesananDataTable(Request $request)
    {
        $pesanan = Pesanan::with('produk', 'user')->orderByDesc('id');
        if ($request->has('diantar') && $request->input('diantar') != '') {
            $pesanan->where('diantar', $request->input('diantar'));
        }
        if ($request->has('jenis') && $request->input('jenis') != '') {
            $pesanan->where('jenis', $request->input('jenis'));
        }
        if ($request->has('id_produk') && $request->input('id_produk') != '') {
            $pesanan->where('id_produk', $request->input('id_produk'));
        }

        return DataTables::of($pesanan)
            ->addColumn('action', function ($pesanan) {
                return view('admin.pesanan.components.actions', compact('pesanan'));
            })
            ->addColumn('tanggal', function ($pesanan) {
                return $pesanan->created_at->format('d F Y');
            })
            ->addColumn('produk_txt', function ($pesanan) {
                return '<strong>' . $pesanan->produk->nama_produk . '</strong><br>Rp ' . number_format($pesanan->produk->harga_produk) . ' /' . $pesanan->produk->satuan_produk;
            })
            ->addColumn('jumlah', function ($pesanan) {
                return '<strong class="text-danger">' . $pesanan->jumlah . '</strong> ' . $pesanan->produk->satuan_produk;
            })
            ->addColumn('tagihan', function ($pesanan) {
                return 'Rp ' . number_format($pesanan->total_harga);
            })
            ->addColumn('pengantaran', function ($pesanan) {
                return $pesanan->diantar == 1 ? '<span class="badge badge-primary">Diantar</span>' : '<span class="badge badge-danger">Tidak</span>';
            })
            ->addColumn('invoice', function ($pesanan) {
                return $pesanan->jenis == 'order' ?  $pesanan->no_invoice . '<br><span class="badge badge-primary">Order</span>'  : $pesanan->no_invoice . '<br><span class="badge badge-danger">Pre-order</span>';
            })
            ->rawColumns(['action', 'produk_txt', 'jumlah', 'tanggal', 'tagihan', 'pengantaran', 'invoice'])
            ->make(true);
    }
    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required',
            'id_produk' => 'required',
            'jumlah' => 'required|string',
            'diantar' => 'required|string',
            'nama_penerima' => 'nullable|string',
            'nomor_penerima' => 'nullable|string',
            'alamat_pengantaran' => 'nullable|string',
        ]);
        $produk = Produk::find($request->input('id_produk'));
        $PesananData = [
            'id_user' => $request->input('id_user'),
            'id_produk' => $request->input('id_produk'),
            'jumlah' => $request->input('jumlah'),
            'diantar' => $request->input('diantar'),
            'nama_penerima' => $request->input('nama_penerima'),
            'nomor_penerima' => $request->input('nomor_penerima'),
            'alamat_pengantaran' => $request->input('alamat_pengantaran'),
            'total_harga' => $request->input('jumlah') * $produk->harga_produk,
            'no_invoice' => Pesanan::generateInvoiceNumber(),
        ];
        if ($request->input('diantar') == 1) {
            if ($request->input('nama_penerima') == null || $request->input('nama_penerima') == '' || $request->input('nomor_penerima') == null || $request->input('alamat_pengantaran') == null || $request->input('nomor_penerima') == '' || $request->input('alamat_pengantaran') == '') {
                session()->flash('error', 'Jika pesanan ingin diantar, harap untuk mengisi form pengantaran');
                return back()->withInput();
            }

            $area = AreaPengantaran::find($request->input('id_area'));
            // dd($request->input('id_area'));
            $PesananData['biaya_pengantaran'] = $area->harga;
            $PesananData['total_harga'] =  ($request->input('jumlah') * $produk->harga_produk) + $area->harga;
        }

        $cek_stok = Stok::getStok($request->input('id_produk'));
        if ($cek_stok < $request->input('jumlah')) {
            $PesananData['jenis'] = 'pre-order';
        } else {
            $PesananData['jenis'] = 'order';
        }

        if ($request->filled('id')) {
            $Pesanan = Pesanan::find($request->input('id'));
            if (!$Pesanan) {
                return response()->json(['message' => 'Pesanan not found'], 404);
            }

            $Pesanan->update($PesananData);
            $message = 'Pesanan updated successfully';
            return response()->json(['message' => $message]);
        } else {
            Pesanan::create($PesananData);
            if ($PesananData['jenis'] == 'pre-order') {
                session()->flash('success', 'Berhasil, jumlah pada pesanan anda melebihi stok yang tersedia dan akan dialihkan ke pre-order');
            } else {
                //jual stok
                $stok = new Stok();
                $stok->id_produk = $request->input('id_produk');
                if ($cek_stok < $request->input('jumlah')) {
                    $stok->jumlah = $cek_stok;
                } else {
                    $stok->jumlah = $request->input('jumlah');
                }
                $stok->jenis = 'penjualan';
                $stok->save();

                session()->flash('success', 'Pesanan berhasil di buat');
            }
            if ($request->has('id_keranjang')) {
                $keranjang  = Keranjang::find($request->id_keranjang);
                $keranjang->delete();
            }

            if (Auth::user()->role == 'User') {

                session()->flash('success', 'Pesanan berhasil di buat');
                return redirect()->to('/pesanan');
            } else {
                session()->flash('success', 'Pesanan berhasil di buat');
                return back();
            }
        }
    }
    public function dibatalkan($id)
    {
        $Pesanan = Pesanan::find($id);

        if (!$Pesanan) {
            session()->flash('error', 'Pesanan tidak tersedia');
            return back();
        }

        if ($Pesanan->jenis == 'order') {
            $stok = new Stok();
            $stok->id_produk = $Pesanan->id_produk;
            $stok->jumlah = $Pesanan->jumlah;
            $stok->jenis = 'masuk';
            $stok->save();
        }

        $Pesanan->delete();
        session()->flash('success', 'Pesanan anda berhasil dibatalkan');
        return back();
    }
    public function edit($id)
    {
        $Pesanan = Pesanan::with(['produk', 'user'])->where('id', $id)->first();

        if (!$Pesanan) {
            return response()->json(['message' => 'Pesanan not found'], 404);
        }

        return response()->json($Pesanan);
    }
}