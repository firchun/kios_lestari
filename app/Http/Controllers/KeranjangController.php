<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'id_produk' => 'required',
            'jumlah' => 'required',

        ]);
        $keranjangData = [
            'id_user' => Auth::id(),
            'id_produk' => $request->input('id_produk'),
            'jumlah' => $request->input('jumlah'),
        ];


        Keranjang::create($keranjangData);
        session()->flash('success', 'berhasil memasukkan pada keranjang');
        return redirect()->back();
    }
    public function destroy($id)
    {
        $keranjang = Keranjang::find($id);
        $keranjang->delete();
        session()->flash('success', 'berhasil menghapus dari keranjang');
        return redirect()->back();
    }
}
