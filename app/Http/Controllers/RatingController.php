<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'id_produk' => 'required',
            'id_pesanan' => 'required',
            'rating' => 'required',
            'ulasan' => 'required',

        ]);
        $ratingData = [
            'id_produk' => $request->input('id_produk'),
            'id_pesanan' => $request->input('id_pesanan'),
            'rating' => $request->input('rating'),
            'ulasan' => $request->input('ulasan'),
        ];


        Rating::create($ratingData);
        session()->flash('success', 'berhasil mengirim rating dan ulasan');
        return redirect()->back();
    }
}
