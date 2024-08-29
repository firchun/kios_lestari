<?php

namespace App\Http\Controllers;

use App\Models\Pengantaran;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class PengantaranController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Data pengantaran pesanan'
        ];
        return view('admin.pengantaran.index', $data);
    }
    public function store(Request $request)
    {

        $pengantaranData = [
            'id_pesanan' => $request->input('id_pesanan'),
            'nama_pengantar' => $request->input('nama_pengantar'),
            'keterangan' => $request->input('keterangan'),

        ];

        if ($request->filled('id_pengantaran')) {
            $Pengantaran = Pengantaran::find($request->input('id_pengantaran'));
            if (!$Pengantaran) {
                return response()->json(['message' => 'Pengantaran not found'], 404);
            }
            $pengantaranUpdate = [
                'sampai' => $request->input('sampai'),
            ];
            if ($request->hasFile('foto_bukti')) {
                $file = $request->file('foto_bukti');
                $filePath = $file->store('foto_pengantaran', 'public'); // Simpan di disk 'public'
                $pengantaranUpdate['foto_bukti'] = $filePath; // Update path file
            }


            $Pengantaran->update($pengantaranUpdate);

            $pesanan = Pesanan::find($Pengantaran->id_pesanan);
            $pesanan->status = 'pesanan sampai di lokasi tujuan';
            $pesanan->save();

            $message = 'Pengantaran updated successfully';
        } else {
            Pengantaran::create($pengantaranData);
            $Pesanan = Pesanan::find($request->input('id_pesanan'));
            $Pesanan->status = 'pesanan dalam pengantaran';
            $Pesanan->save();

            $message = 'Pengantaran created successfully';
        }

        return response()->json(['message' => $message]);
    }
    public function pesanan($id)
    {
        $Pengantaran = Pengantaran::where('id_pesanan', $id)->first();

        // if (!$Pengantaran) {
        //     return response()->json(['message' => 'Pengantaran not found'], 404);
        // }

        return response()->json($Pengantaran);
    }
    public function getPengantaranDataTable(Request $request)
    {
        $pengantaran = Pengantaran::with(['pesanan.produk'])->orderByDesc('id');
        if ($request->has('sampai') && $request->input('sampai') != '') {
            $pengantaran->where('sampai', $request->input('sampai'));
        }
        if ($request->has('id_produk') && $request->input('id_produk') != '') {
            $idProduk = $request->input('id_produk');
            $pengantaran->whereHas('pesanan', function ($query) use ($idProduk) {
                $query->where('id_produk', $idProduk);
            });
        }
        return DataTables::of($pengantaran)
            ->addColumn('bukti', function ($pengantaran) {
                if ($pengantaran->sampai == 1) {

                    return '<a href="' . Storage::url($pengantaran->foto_bukti) . '" target="__blank"><img src="' . Storage::url($pengantaran->foto_bukti) . '" style="width:100px;height:100px;object-fit:cover;"></a>';
                } else {
                    return 'dalam pengantaran';
                }
            })

            ->rawColumns(['bukti'])
            ->make(true);
    }
}
