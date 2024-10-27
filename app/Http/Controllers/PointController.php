<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\point;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PointController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Data point pelanggan'
        ];
        return view('admin.point.index', $data);
    }
    public function getPointDataTable()
    {
        $users = User::where('role', 'User')->orderByDesc('id');

        return DataTables::of($users)

            ->addColumn('action', function ($user) {
                return '<button type="button" onclick="change(' . $user->id . ')" class="btn btn-warning">Gunakan</button>';
            })
            ->addColumn('point', function ($user) {
                $jumlah = Pesanan::where('id_user', $user->id)->count();
                $reward = Setting::first()->point;
                $terpakai = point::where('id_user', $user->id)->sum('jumlah');
                return '<span class="font-weight-bold h5 text-danger">' . number_format(($jumlah * $reward) - $terpakai) . '</span> Point';
            })
            ->addColumn('saldo', function ($user) {
                $jumlah = Pesanan::where('id_user', $user->id)->count();
                $reward = Setting::first()->point;
                $saldo = Setting::first()->saldo_point;
                $terpakai = point::where('id_user', $user->id)->sum('jumlah');
                return '<span class="font-weight-bold h5 text-danger">Rp ' . number_format((($jumlah  * $reward) - $terpakai) * $saldo) . '</span>';
            })
            ->rawColumns(['action', 'point', 'saldo'])
            ->make(true);
    }
    public function store(Request $request)
    {
        //hitung point
        $jumlah = Pesanan::where('id_user', $request->input('id_user'))->count();
        $reward = Setting::first()->point;
        $terpakai = point::where('id_user', $request->input('id_user'))->sum('jumlah');
        $point_user = ($jumlah * $reward) - $terpakai;
        //simpan point
        $point = new point();
        $point->id_user = $request->input('id_user');
        $point->jumlah = $request->input('jumlah') > $point_user ? $point_user : $request->input('jumlah');
        $point->save();

        $message = 'Berhasil mengubah Point';
        return response()->json(['message' => $message]);
    }
}
