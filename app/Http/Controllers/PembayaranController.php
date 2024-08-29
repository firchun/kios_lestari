<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class PembayaranController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Data Pembayaran Pemesanan',
        ];
        return
            view('admin.pembayaran.index', $data);
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $pembayaranData = [
            'id_pesanan' => $request->input('id_pesanan'),
            'jumlah' => $request->input('jumlah'),
        ];


        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filePath = $file->store('foto_pembayaran', 'public');
            $pembayaranData['foto'] = $filePath;
        }

        Pembayaran::create($pembayaranData);
        session()->flash('success', 'Berhasil upload bukti pembayaran');
        return redirect()->back();
    }
    public function getPembayaranDataTable(Request $request)
    {
        $pembayaran = Pembayaran::with(['pesanan'])->orderByDesc('id');
        if ($request->has('id_produk') && $request->input('id_produk') != '') {
            $idProduk = $request->input('id_produk');
            $pembayaran->whereHas('pesanan', function ($query) use ($idProduk) {
                $query->where('id_produk', $idProduk);
            });
        }
        if ($request->has('terverifikasi') && $request->input('terverifikasi') != '') {
            $pembayaran->where('terverifikasi', $request->input('terverifikasi'));
        }
        return DataTables::of($pembayaran)
            ->addColumn('foto', function ($pembayaran) {

                return '<a href="' . Storage::url($pembayaran->foto) . '" target="__blank"><img src="' . Storage::url($pembayaran->foto) . '" style="width:100px;height:100px;object-fit:cover;"></a>';
            })
            ->addColumn('produk', function ($pembayaran) {
                return $pembayaran->pesanan->produk->nama_produk;
            })
            ->addColumn('pelanggan', function ($pembayaran) {
                return $pembayaran->pesanan->user->name;
            })
            ->addColumn('action', function ($pembayaran) {
                if ($pembayaran->terverifikasi == 0) {
                    return '<a href="' . route('pembayaran.verifikasi', $pembayaran->id) . '" class="btn btn-primary">Verifikasi</a>';
                } else {
                    return 'Terverifikasi';
                }
            })

            ->rawColumns(['foto', 'produk', 'pelanggan', 'action'])
            ->make(true);
    }
    public function verifikasi($id)
    {
        $pembayaran = Pembayaran::find($id);
        $pembayaran->terverifikasi = 1;
        $pembayaran->save();
        session()->flash('success', 'Berhasil berifikasi bukti pembayaran');
        return redirect()->back();
    }
}