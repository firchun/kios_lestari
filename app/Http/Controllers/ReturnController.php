<?php

namespace App\Http\Controllers;

use App\Models\PengajuanReturn;
use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Stmt\Return_;
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
        $return = PengajuanReturn::with(['pesanan'])->orderByDesc('id');

        return DataTables::of($return)
            ->addColumn('tanggal', function ($return) {
                return $return->created_at->format('d F Y');
            })
            ->addColumn('foto', function ($return) {
                return '<a href="' . Storage::url($return->foto) . '" target="__blank"><img src="' . Storage::url($return->foto) . '" style="width:100px;height:100px;object-fit:cover;"></a>';
            })
            ->addColumn('produk', function ($return) {
                return $return->pesanan->produk->nama_produk;
            })
            ->addColumn('action', function ($return) {
                if ($return->disetujui == 0) {
                    return '<a href="' . route('return.setujui', $return->id) . '" class="btn btn-primary">Setujui</a>';
                } else {
                    if ($return->selesai == 0) {
                        return '<a href="' . route('return.selesai', $return->id) . '" class="btn btn-success">Selesai</a>';
                    } else {
                        return 'Return selesai';
                    }
                }
            })
            ->rawColumns(['produk', 'tanggal', 'foto', 'action'])
            ->make(true);
    }
    public function store(Request $request)
    {
        $request->validate([
            'id_pesanan' => 'required',
            'jumlah' => 'required',
            'keterangan' => 'required',
            'foto' => 'required',
        ]);
        $returnData = [
            'id_pesanan' =>  $request->input('id_pesanan'),
            'jumlah' => $request->input('jumlah'),
            'keterangan' => $request->input('keterangan'),
        ];
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filePath = $file->store('foto_return', 'public'); // Simpan di disk 'public'
            $returnData['foto'] = $filePath; // Update path file
        }

        PengajuanReturn::create($returnData);
        session()->flash('success', 'berhasil mengirim pengajuan return produk');
        return redirect()->back();
    }
    public function setujui($id)
    {
        $return = PengajuanReturn::find($id);
        $return->disetujui = 1;
        $return->save();
        session()->flash('success', 'berhasil menyetujui pengajuan return produk');
        return redirect()->back();
    }
    public function selesai($id)
    {
        $return = PengajuanReturn::find($id);
        $return->selesai = 1;
        $return->save();
        session()->flash('success', 'berhasil menyelesaikan return produk');
        return redirect()->back();
    }
}
